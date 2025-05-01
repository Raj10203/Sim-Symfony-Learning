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
        UserFactory::createOne([
            'email'=>'admin@example.com',
            'password'=>'$2y$13$X7NAK5yb3QLcf9z2oalmwutggedQJwdvnyJUcodinQrYVsglPdvCi',
        ]);
        $manager->flush();
    }
}
