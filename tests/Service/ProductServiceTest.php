<?php

namespace App\Tests\Service;

use App\Repository\ProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductServiceTest extends TestCase
{
    public function testNewWithEmptyData(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Expecting mandatory parameters');
        $productRepositoryMock = $this->createMock(ProductRepository::class);
        $productRepositoryMock->expects($this->any())
            ->method('save');
        $productService = new ProductService($productRepositoryMock);
        $productService->new([]);

    }

    public function testCalculatePriceWithTax(){
        $productRepositoryMock = $this->createMock(ProductRepository::class);
        $productService = new ProductService($productRepositoryMock);
        $this->assertEquals(121,$productService->calculatePriceWithTax(100,21));
    }
}
