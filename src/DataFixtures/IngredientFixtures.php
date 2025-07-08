<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Faker\Factory;
use App\Entity\Recipe;

class IngredientFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create("fr_FR");

    }
    public function load(ObjectManager $manager): void
    {
        // Ingredients
        for ($i=0; $i <= 50 ; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice($this->faker->randomFloat(2, 0.5, 100));

                $ingredients[] = $ingredient;
                $manager->persist($ingredient);
        }
    

         // Recettes 
         for ($j = 0; $j <= 25; $j++) { 
            $recipe = new Recipe();
            $recipe->setNom($this->faker->word())
                   ->setTime(mt_rand(0, 1) ? mt_rand(1, 1440) : null)
                   ->setNbPersonne(mt_rand(0, 1) ? mt_rand(1, 50) : null)
                   ->setDifficulte(mt_rand(0, 1) ? mt_rand(1, 6) : null)
                   ->setDescription($this->faker->text(300))
                   ->setPrix(mt_rand(0, 1) ? mt_rand(1, 1000) : null)
                   ->setFavorite((bool) mt_rand(0, 1));
        
            for ($k = 0; $k < mt_rand(5, 15); $k++) { 
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }
        
            $manager->persist($recipe);       

        }
    

        $manager->flush();
    }
}
