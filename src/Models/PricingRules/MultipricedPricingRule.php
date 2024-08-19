<?php

namespace Checkout\Models\PricingRules;

use Checkout\Abstracts\PricingRule;
use Checkout\Interfaces\ItemInterface;

class MultipricedPricingRule extends PricingRule
{
    public function __construct(private readonly string $sku, private readonly int $requiredQuantity, private readonly int $specialPrice)
    {
    }

    public function calculatePrice(ItemInterface $item, array $cartItems): float|int
    {
        $count = 0;

        array_map(function ($cartItem) use ($item, &$count) {
            if ($item->getSku() === $cartItem->getSku()) {
                $count++;
            }
        }, $cartItems);

        if ($count === $this->getRequiredQuantity()) {
            return $this->specialPrice;
        }

        if ($count > $this->getRequiredQuantity()) {
            return (floor($count / $this->getRequiredQuantity()) * $this->specialPrice) + (($count % $this->getRequiredQuantity()) * $item->getUnitPrice());
        }

        return $count * $item->getUnitPrice();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getRequiredQuantity(): int
    {
        return $this->requiredQuantity;
    }
}