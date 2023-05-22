<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Countries;

class CountryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++){
        $faker = \Faker\Factory::create();
        $country = new Countries();
        $country->setName($faker->country())->setIso($faker->countrycode());
        $manager->persist($country);
    }
        $manager->flush();
    }
}
