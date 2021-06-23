<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $tax;

    /**
     * @ORM\Column(type="float")
     */
    private $priceWithTax;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTax(): ?string
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     * @return Product
     */
    public function setTax(int $tax): self
    {

        if (!in_array($tax, array(4,10,21))) {
            throw new \InvalidArgumentException("Invalid tax");
        }
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceWithTax(): ?float
    {
        return $this->priceWithTax;
    }

    /**
     * @param float $priceWithTax
     * @return Product
     */
    public function setPriceWithTax(float $priceWithTax): self
    {
        $this->priceWithTax = $priceWithTax;

        return $this;
    }
}
