<?php

namespace App\DataFixtures;

use App\Entity\Steps;
use App\Entity\Recipe;
use App\Entity\Ingredients;
use App\Entity\MeasurementUnits;
use App\Entity\RecipeIngredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RecipeFixtures extends Fixture
{
    private $params;
    private $manager;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;


        $httpClient = HttpClient::create();
        $apiKey = $this->params->get('spoonacular_api_key');
        $number = 10;
        $randomYieldQuantity = rand(1, 8);  // For a random quantity between 1 and 8

        $url = "https://api.spoonacular.com/recipes/random?apiKey={$apiKey}&number={$number}";

        $response = $httpClient->request('GET', $url);

        if ($response->getStatusCode() == 200) {

            $data = $response->toArray();


            // Retrieve all existing ingredients and units of measurement to avoid duplication
            $existingIngredients = $this->manager->getRepository(Ingredients::class)->findAll();
            $existingIngredients = array_flip(array_map(function ($ingredient) {
                return $ingredient->getName();
            }, $existingIngredients));

            $existingUnits = $this->manager->getRepository(MeasurementUnits::class)->findAll();
            $existingUnits = array_flip(array_map(function ($unit) {
                return $unit->getName();
            }, $existingUnits));

            foreach ($data['recipes'] as $recipeData) {
                $recipe = new Recipe();
                $recipe->setTitle($recipeData['title']);
                $slugger = new AsciiSlugger();
                $recipe->setSlug($slugger->slug($recipeData['title'])->lower());
                $recipe->setContent($recipeData['summary']);
                $recipe->setYieldQuantity($randomYieldQuantity);
                $defaultCookTime = new \DateTime('@0'); // A date with zero timestamp
                $defaultCookTime->add(new \DateInterval('PT30M')); // Add 30 minutes
                $recipe->setCookTime($defaultCookTime);
                $recipe->setCreatedAt(new \DateTime()); // Or use the API creation date if available

                // Ingredients
                foreach ($recipeData['extendedIngredients'] as $ingredientData) {
                    // Check if the unit of measure already exists
                    if (!isset($existingUnits[$ingredientData['unit']])) {
                        $measurementUnit = new MeasurementUnits();
                        $measurementUnit->setName($ingredientData['unit']);

                        // Abbreviation generation
                        $unitsAbbreviationMap = [
                            'kilogram' => 'kg',
                            'gram' => 'g',
                            'liter' => 'L',

                        ];
                        $abbreviation = $unitsAbbreviationMap[$ingredientData['unit']] ?? strtoupper(substr($ingredientData['unit'], 0, 3));
                        $measurementUnit->setAbbreviation($abbreviation);

                        $this->manager->persist($measurementUnit);
                        $existingUnits[$ingredientData['unit']] = $measurementUnit;
                    } else {
                        $measurementUnit = $existingUnits[$ingredientData['unit']];
                    }

                    // Check if the ingredient already exists
                    if (!isset($existingIngredients[$ingredientData['name']])) {
                        $ingredient = new Ingredients();
                        $ingredient->setName($ingredientData['name']);
                        $this->manager->persist($ingredient);
                        $existingIngredients[$ingredientData['name']] = $ingredient;
                    } else {
                        $ingredient = $existingIngredients[$ingredientData['name']];
                    }

                    $recipeIngredient = new RecipeIngredient();
                    $recipeIngredient->setRecipes($recipe);
                    $recipeIngredient->setIngredients($ingredient);
                    $recipeIngredient->setQuantity($ingredientData['amount']);

                    // Check if the unit of measure already exists
                    if (!isset($existingUnits[$ingredientData['unit']])) {
                        $measurementUnit = new MeasurementUnits();
                        $measurementUnit->setName($ingredientData['unit']);
                        $this->manager->persist($measurementUnit);
                        $existingUnits[$ingredientData['unit']] = $measurementUnit;
                    } else {
                        $measurementUnit = $existingUnits[$ingredientData['unit']];
                    }
                    $recipeIngredient->setUnit($measurementUnit);

                    $this->manager->persist($recipeIngredient);
                }

                // Étapes
                if (isset($recipeData['analyzedInstructions'][0]['steps'])) {
                    foreach ($recipeData['analyzedInstructions'][0]['steps'] as $stepData) {
                        $step = new Steps();
                        $step->setTitle("Étape " . $stepData['number']);
                        $step->setContent($stepData['step']);
                        $step->setRecipe($recipe);
                        $this->manager->persist($step);
                    }
                }

                $this->manager->persist($recipe);
            }

            $manager->flush();
        } else {
            // Error handling, e.g. logging or throwing an exception
        }
    }
}
