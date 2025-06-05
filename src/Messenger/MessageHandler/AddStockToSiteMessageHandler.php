<?php

namespace App\Messenger\MessageHandler;

use App\Entity\ActiveInventory;
use App\Messenger\Message\AddStockToSiteMessage;
use App\Repository\ActiveInventoryRepository;
use App\Repository\InventoryRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddStockToSiteMessageHandler
{
    public function __construct(
        private readonly InventoryRepository $inventoryRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }
    public function __invoke(AddStockToSiteMessage $message): void
    {
        $quantity = $message->getQuantity();
        $inventory = $this->inventoryRepository->find($message->getInventoryId());

        $inventory->setQuantity($inventory->getQuantity() + $quantity);
        for ($i = 0; $i < $quantity; ++$i) {
            $activeInventory = new ActiveInventory();
            $activeInventory->setProduct($inventory->getProduct());
            $activeInventory->setSite($inventory->getSite());
            $activeInventory->setReceivedAt(new \DateTimeImmutable());

            $this->entityManager->persist($activeInventory);
            $this->entityManager->flush();
        }
    }
}