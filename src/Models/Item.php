<?php

namespace Checkout\Models;

use Checkout\Interfaces\ItemInterface;

class Item implements ItemInterface
{
    public function __construct(private string $sku, private $unitPrice)
    {
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
}