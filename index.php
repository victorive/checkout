<?php

require './vendor/autoload.php';

use Checkout\Models\Item;
use Checkout\Models\PricingRules\BuyNGetOneFreePricingRule;
use Checkout\Models\PricingRules\MealDealPricingRule;
use Checkout\Models\PricingRules\MultipricedPricingRule;
use Checkout\Models\PricingRules\PricingRule;
use Checkout\Services\CheckoutService;

$pricingRules = new PricingRule();

$pricingRules->addPricingRule(new MultipricedPricingRule('B', 2, 125));
//$pricingRules->addPricingRule(new BuyNGetOneFreePricingRule('A', 2));
//$pricingRules->addPricingRule(new MealDealPricingRule(['D', 'E'], 300));

$checkout = new CheckoutService($pricingRules);

$item1 = new Item('B', 75);
$item2 = new Item('A', 50);
$item3 = new Item('B', 75);

$checkout->scanItem($item1);
$checkout->scanItem($item2);
$checkout->scanItem($item3);

echo number_format(($checkout->calculateTotal() / 100), 2);
