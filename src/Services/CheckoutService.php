<?php

namespace Checkout\Services;

use Checkout\Interfaces\ItemInterface;
use Checkout\Models\PricingRules\PricingRule;

class CheckoutService
{
    private array $items = [];

    private array $itemsWithAppliedRules = [];

    public function __construct(private readonly PricingRule $pricingRule)
    {
    }

    public function scanItem(ItemInterface $item): void
    {
        $this->items[] = $item;
    }

    public function calculateTotal(): float|int
    {
        $total = 0;

        foreach ($this->items as $item) {
            if (!in_array($item->getSku(), $this->itemsWithAppliedRules, true)) {
                $pricingRule = $this->pricingRule->getPricingRuleForItem($item);

                if ($pricingRule) {
                    $total += $pricingRule->calculatePrice($item, $this->items);
                    $this->itemsWithAppliedRules[] = $item->getSku();
                } else {
                    $total += $item->getUnitPrice();
                }
            }
        }

        return $total;
    }
}