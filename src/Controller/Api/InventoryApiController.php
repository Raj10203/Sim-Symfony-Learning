<?php

namespace App\Controller\Api;

use App\Repository\InventoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/inventory')]
#[IsGranted('ROLE_USER')]
final class InventoryApiController extends DefaultApiController
{
    public function __construct(private InventoryRepository $repo)
    {
    }

    #[Route('/datatable', name: 'api_inventory_datatable', methods: ['POST'])]
    public function index(Request $request): Response
    {

        $start = (int) $request->get('start', 0);
        $length = (int) $request->get('length', 10);
        $search = $request->get('search')['value'] ?? '';
        $order = $request->get('order')[0] ?? null;
        $columns = $request->get('columns');

        $qb = $this->repo->createQueryBuilder('i')
            ->leftJoin('i.product', 'p')
            ->leftJoin('i.site', 's')
            ->addSelect('p', 's');

        // Apply search
        if (!empty($search)) {
            $qb->andWhere('p.name LIKE :search OR s.name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        // Apply ordering
        if ($order && isset($columns[$order['column']])) {
            $columnName = $columns[$order['column']]['data'] ?? null;

            // Map column names to DQL aliases
            $columnMap = [
                'id' => 'i.id',
                'product' => 'p.name',
                'site' => 's.name',
                'quantity' => 'i.quantity',
                'createdAt' => 'i.createdAt',
                'updatedAt' => 'i.updatedAt',
            ];

            if (isset($columnMap[$columnName])) {
                $qb->orderBy($columnMap[$columnName], strtoupper($order['dir'])); // ASC or DESC
            }
        }

        $total = (clone $qb)->select('COUNT(i.id)')->getQuery()->getSingleScalarResult();

        $qb->setFirstResult($start)
            ->setMaxResults($length);

        $inventories = $qb->getQuery()->getResult();

        $data = array_map(function ($i) {
            return [
                'id' => $i->getId(),
                'product' => $i->getProduct()?->getName(),
                'site' => $i->getSite()?->getName(),
                'quantity' => $i->getQuantity(),
                'createdAt' => $i->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $i->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ];
        }, $inventories);

        return $this->json([
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'draw' => (int) $request->get('draw'),
        ]);
    }
}