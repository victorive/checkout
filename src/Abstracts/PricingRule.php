<?php

namespace Checkout\Abstracts;

use Checkout\Interfaces\ItemInterface;
use Checkout\Interfaces\PricingRuleInterface;

abstract class PricingRule implements PricingRuleInterface
{
    abstract public function calculatePrice(ItemInterface $item, array $cartItems);
}