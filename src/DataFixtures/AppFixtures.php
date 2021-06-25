<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function load(ObjectManager $manager)
    {
    $elements = [
        'name' => 'camisa',
        'description' => 'descripcion camisa',
        'price' => 10,
        'tax' => [4,10,21]
    ];
    $times = 10;

        for($i = 0; $i < $times; $i++) {
            $tax = $elements['tax'][rand(0,2)];
            $price = $elements['price']+$i;
            $product = new Product();
            $product->setName($elements['name'].'_'.$i);
            $product->setDescription($elements['description'].'_'.$i);
            $product->setPrice($price);
            $product->setPriceWithTax($this->productService->calculatePriceWithTax($price, $tax));
            $product->setTax($tax);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
