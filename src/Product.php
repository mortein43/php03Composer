<?php

namespace OrgEizenheim\Composer;

class Product
{

    public string $name;
    public int $count;
    public int $price;

    /**
     * @param string $name
     * @param int $count
     * @param int $price
     */
    public function __construct(string $name, int $count, int $price)
    {
        $this->name = $name;
        $this->count = $count;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

}