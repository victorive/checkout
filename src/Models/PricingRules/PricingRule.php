<?php

namespace Checkout\Models\PricingRules;

use Checkout\Interfaces\ItemInterface;
use Checkout\Interfaces\PricingRuleInterface;

class PricingRule
{
    private array $rules = [];

    public function addPricingRule(PricingRuleInterface $rule): void
    {
        $this->rules[] = $rule;
    }

    public function getPricingRuleForItem(ItemInterface $item): MultipricedPricingRule|BuyNGetOneFreePricingRule|MealDealPricingRule|null
    {
        foreach ($this->rules as $rule) {
            if ($rule instanceof MultipricedPricingRule && $rule->getSku() === $item->getSku()) {
                return $rule;
            }

            if ($rule instanceof BuyNGetOneFreePricingRule && $rule->getSku() === $item->getSku()) {
                return $rule;
            }

            if ($rule instanceof MealDealPricingRule && in_array($item->getSku(), $rule->getItems(), true)) {
                return $rule;
            }
        }

        return null;
    }

    public function getRules(): array
    {
        return $this->rules;
    }
}