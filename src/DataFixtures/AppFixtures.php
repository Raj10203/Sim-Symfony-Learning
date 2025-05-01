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
        SitesFactory::createOne(['name'=>'Headquarters']);
        SitesFactory::createMany(5);
        UserFactory::createOne([
            'email'=>'admin@example.com',
            'password'=>'$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
            'roles'=>['ROLE_ADMIN'],
        ]);
        UserFactory::createMany(5);
        CategoriesFactory::createMany(10);
        ProductsFactory::createMany(40);
        StockRequestFactory::createMany(5);
        StockRequestItemsFactory::createMany(40);
        $manager->flush();
    }
}
