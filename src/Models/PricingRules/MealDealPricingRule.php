<?php

namespace Checkout\Models\PricingRules;

use Checkout\Abstracts\PricingRule;
use Checkout\Interfaces\ItemInterface;

class MealDealPricingRule extends PricingRule
{
    public function __construct(private array $items, private $price)
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function calculatePrice(ItemInterface $item, array $cartItems): mixed
    {
        $found = true;

        $cartItemSkus = array_map(function ($cartItem) {
            return $cartItem->getSku();
        }, $cartItems);

        foreach ($this->items as $sku) {
            if (!in_array($sku, $cartItemSkus, true)) {
                $found = false;
                break;
            }
        }

        if ($found) {
            $cartItemCounts = array_count_values($cartItemSkus);

            foreach ($this->items as $sku) {
                if ($cartItemCounts[$sku] < 1) {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                // Apply the discount only once
                static $applied = false;
                if (!$applied) {
                    $applied = true;
                    return $this->price;
                }

                return 0;
            }
        }

        return $item->getUnitPrice();
    }
}