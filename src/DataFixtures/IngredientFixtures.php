<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Faker\Factory;

class IngredientFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create("fr_FR");

    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i <= 50 ; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice($this->faker->randomFloat(2, 0.5, 100));

                $manager->persist($ingredient);
        }
    

        $manager->flush();
    }
}
