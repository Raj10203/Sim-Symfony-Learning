<?php

namespace App\Messenger\MessageHandler;

use App\Entity\Inventory;
use App\Messenger\Message\AddProductMessage;
use App\Repository\ProductRepository;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddProductMessageHandler
{
    public function __construct(
        private readonly ProductRepository      $productRepository,
        private readonly SiteRepository         $siteRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(AddProductMessage $message)
    {
        $productId = $message->getProductId();
        $product = $this->productRepository->find($productId);

        $sites = $this->siteRepository->findAll();

        foreach ($sites as $site) {
            $inventory = new Inventory();
            $inventory->setProduct($product);
            $inventory->setSite($site);
            $inventory->setQuantity(0);
            $this->entityManager->persist($inventory);
            $this->entityManager->flush();
        }
    }
}