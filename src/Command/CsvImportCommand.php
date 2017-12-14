<?php

namespace App\Command;

use App\Entity\Additives;
use App\Entity\Brands;
use App\Entity\Countries;
use App\Entity\Ingredients;
use App\Entity\NutritionalInformation;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class CsvImportCommand
 * @package App\ConsoleCommand
 */
class CsvImportCommand extends Command
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports a CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title=('Attempting to import the feed...');

        $csv = Reader::createFromPath('%kernel_root_dir%/../src/Data/openFoodFacts.csv', 'r');
        //$reader = Reader::createFromPath( path: '%kernel_root_dir%/../src/Data/openFoodFacts.csv');

        //$results = $csv->fetchAssoc();
        $csv->setHeaderOffset(0);

        $input_bom = $csv->getInputBOM();

        if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
            CharsetConverter::addTo($csv, 'utf-16', 'utf-8');
        }

        $io->progressStart(iterator_count($csv));

        foreach($csv as $row)
        {
            /**
             * Create new PRODUCT
             * @var Product $product
             */
            $product = new Product();
            $product->setUrl($row['url']);
            //Entering data process for product_name (ucfirst)
            $product_cap = strtolower($row['product_name']);
            $product_cap = ucfirst($product_cap);
            $product->setProductName($product_cap);
            $product->setServingSize($row['serving_size']);
            $product->setAdditivesN($row['additives_n']);
            $product->setIngredientsFromPalmOilN($row['ingredients_from_palm_oil_n']);
            $product->setIngredientsThatMayBeFromPalmOilN($row['ingredients_that_may_be_from_palm_oil_n']);

            $this->em->persist($product);


            /**
             * Create new ADDITIVES
             * @var Additives $additive
             */
            $additive = new Additives();
            $additive->setAdditiveFr($row['additives_fr']);

            $this->em->persist($additive);
            //Add the additive at list additives to product
            $product->addAdditive($additive);


            /**
             * Create new BRANDS
             * @var Brands $brand
             */
            $brand = new Brands();
            $brand->setBrand($row['brands']);
            $brand->setBrandTags($row['brands_tags']);

            $this->em->persist($brand);

            $product->setBrand($brand);


            /**
             * Create new COUNTRIES
             * @var Countries $country
             */
            $country = new Countries();
            $country->setCountryFr($row['countries_fr']);

            $this->em->persist($country);

            $product->setCountry($country);


            /**
             * Create new INGREDIENTS
             * @var Ingredients $ingredient
             */
            $ingredient = new Ingredients();
            $ingredient->setIngredient($row['ingredients_text']);

            $this->em->persist($ingredient);
            //Add the ingredient at list ingredients to product
            $product->addIngredient($ingredient);


            /**
             * Create new NUTRIONAL_INFORMATION
             * @var NutritionalInformation $nutritional_information
             */
            $nutritional_information = new NutritionalInformation();
            $nutritional_information->setNutritionGradeFr($row['nutrition_grade_fr']);
            $nutritional_information->setEnergy100g($row['energy_100g']);
            $nutritional_information->setFat100g($row['fat_100g']);
            $nutritional_information->setSaturatedFat100g($row['saturated-fat_100g']);
            $nutritional_information->setCholesterol100g($row['cholesterol_100g']);
            $nutritional_information->setCarbohydrates100g($row['carbohydrates_100g']);
            $nutritional_information->setSugars100g($row['sugars_100g']);
            $nutritional_information->setFiber100g($row['fiber_100g']);
            $nutritional_information->setProteins100g($row['proteins_100g']);
            $nutritional_information->setSalt100g($row['salt_100g']);
            $nutritional_information->setSodium100g($row['sodium_100g']);
            $nutritional_information->setVitaminA100g($row['vitamin-a_100g']);
            $nutritional_information->setCalcium100g($row['calcium_100g']);
            $nutritional_information->setIron100g($row['iron_100g']);
            ;

            $this->em->persist($nutritional_information);

            $product->setNutritionalInformation($nutritional_information);

            $io->progressAdvance();
        }

        $io->progressFinish();

        try {
           // ...
           $this->em->flush();
        }
        catch (UniqueConstraintViolationException $e) {
            // ....
        }

        $io->success('CSV is imported !');
    }
}
