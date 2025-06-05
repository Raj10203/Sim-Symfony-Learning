<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\ProductFactory;
use App\Factory\SiteFactory;
use App\Factory\StockRequestFactory;
use App\Factory\StockRequestItemFactory;
use App\Factory\UserFactory;
use App\Messenger\Message\AddStockToSiteMessage;
use App\Repository\InventoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly InventoryRepository $inventoryRepository,
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function load(ObjectManager $manager): void
    {
        $headquarters = SiteFactory::createOne([
            'name' => 'Headquarters',
            'location' => 'https://maps.app.goo.gl/bttWR6EpBGvgccS89'
        ]);
        $adani = SiteFactory::createOne([
            'name' => 'Adani',
            'location' => 'https://maps.app.goo.gl/bttWR6EpBGvgccS89'
        ]);
        $inTransit = SiteFactory::createOne([
            'name' => 'In Transit',
            'location' => 'NA'
        ]);
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => '$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles' => ['ROLE_ADMIN'],
            'site' => $headquarters
        ]);
        UserFactory::createOne([
            'email' => 'hq_manager@example.com',
            'password' => '$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles' => ['ROLE_HQ_MANAGER'],
            'site' => $headquarters
        ]);
        UserFactory::createOne([
            'email' => 'hq_employee@example.com',
            'password' => '$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles' => ['ROLE_HQ_EMPLOYEE'],
            'site' => $headquarters
        ]);
        UserFactory::createOne([
            'email' => 'site_manager@example.com',
            'password' => '$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles' => ['ROLE_SITE_MANAGER'],
            'site' => $adani
        ]);
        UserFactory::createOne([
            'email' => 'site_employee@example.com',
            'password' => '$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles' => ['ROLE_SITE_EMPLOYEE'],
            'site' => $adani
        ]);
        CategoryFactory::createMany(10);
        ProductFactory::createOne();
//        StockRequestFactory::createMany(5);
//        StockRequestItemFactory::createMany(50);
//        for ($i = 0; $i < 10; $i++) {
//            $this->messageBus->dispatch(new AddStockToSiteMessage($i, rand(1, 20)));
//        }
//        $manager->flush();
    }
}
