<?php

namespace Checkout\Models\PricingRules;

use Checkout\Interfaces\ItemInterface;
use Checkout\Abstracts\PricingRule;

class BuyNGetOneFreePricingRule extends PricingRule
{
    public function __construct(private readonly string $sku, private readonly int $requiredQuantity)
    {
    }

    public function getRequiredQuantity(): int
    {
        return $this->requiredQuantity;
    }

    public function calculatePrice(ItemInterface $item, array $cartItems): float|int
    {
        $count = 0;

        array_map(function ($cartItem) use ($item, &$count) {
            if ($item->getSku() === $cartItem->getSku()) {
                $count++;
            }
        }, $cartItems);

        $freeItems = floor($count / ($this->getRequiredQuantity() + 1));

        return $item->getUnitPrice() * ($count - $freeItems);
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}