<?php

namespace Checkout\Interfaces;

interface PricingRuleInterface
{
    public function calculatePrice(ItemInterface $item, array $cartItems);
}