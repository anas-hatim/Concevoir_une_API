<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Countries;
use App\Entity\Animals;
use App\Repository\CountriesRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $countriesRepository;
    
    public function __construct(CountriesRepository $countriesRepository)
    {
        $this->faker = \Faker\Factory::create();
        $this->countriesRepository = $countriesRepository;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les pays existants
        $countries = $this->countriesRepository->findAll();
 
        for ($i = 0; $i < 100; $i++) {
            $animal = new Animals();
            $animal->setName($this->faker->name);
            $animal->setSize($this->faker->numberBetween(1, 10));
            $animal->setLifetime($this->faker->numberBetween(1, 20));
            $animal->setMartialArt($this->faker->optional()->word);
            $animal->setPhone($this->faker->optional()->phoneNumber);
            
            // Assigner un pays aléatoire à l'animal
            $randomCountry = $this->faker->randomElement($countries);
            $animal->setCountry($randomCountry);

            $manager->persist($animal);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
        ];
    }
}
