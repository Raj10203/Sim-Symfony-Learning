<?php

namespace App\DataFixtures;

use App\Factory\SitesFactory;
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
        UserFactory::createOne(['email'=>'admin@example.com']);
        UserFactory::createMany(10);
        $manager->flush();
    }
}
