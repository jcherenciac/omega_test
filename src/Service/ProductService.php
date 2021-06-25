<?php

namespace App\Service;


use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function new( array $data )
    {
        $name = !empty($data['name']) ? $data['name']: false;
        $description = !empty($data['description']) ? $data['description']: false;
        $price = !empty($data['price']) ? floatval($data['price']) : 0;
        $tax = !empty($data['tax']) ? $data['tax']: false;

        if(!$name || !$description || !$price || !$tax){
            throw new NotFoundHttpException('Expecting mandatory parameters');
        }

        $this->productRepository->save(
            $name,
            $description,
            $price ,
            $this->calculatePriceWithTax( $price, $tax),
            $tax
        );
    }

    public function calculatePriceWithTax(float $price, int $tax) :float
    {
        return $price + ($price * $tax / 100);
    }
}