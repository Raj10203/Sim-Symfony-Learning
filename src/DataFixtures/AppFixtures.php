<?php

namespace App\DataFixtures;

use App\Factory\CategoriesFactory;
use App\Factory\ProductsFactory;
use App\Factory\SitesFactory;
use App\Factory\StockRequestFactory;
use App\Factory\StockRequestItemsFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $headquarters = SitesFactory::createOne([
            'name' => 'Headquarters',
            'location' => 'https://maps.app.goo.gl/bttWR6EpBGvgccS89'
        ]);
        $adani = SitesFactory::createOne([
            'name' => 'Adani',
            'location' => 'https://maps.app.goo.gl/bttWR6EpBGvgccS89'
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
        CategoriesFactory::createMany(10);
        ProductsFactory::createMany(20);
        StockRequestFactory::createMany(50);
        StockRequestItemsFactory::createMany(500);
        $manager->flush();
    }
}
