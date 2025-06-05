<?php

namespace App\Messenger\MessageHandler;

use App\Entity\Inventory;
use App\Messenger\Message\AddSiteMessage;
use App\Repository\ProductRepository;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddSiteMessageHandler
{
    public function __construct(
        private readonly ProductRepository      $productRepository,
        private readonly SiteRepository         $siteRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }

    public function __invoke(AddSiteMessage $message)
    {
        $site = $this->siteRepository->find($message->getSiteId());

        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $inventory = new Inventory();
            $inventory->setProduct($product);
            $inventory->setSite($site);
            $inventory->setQuantity(0);
        }
        $this->entityManager->flush();
    }
}