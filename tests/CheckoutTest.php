<?php

namespace Tests;

use Checkout\Models\Item;
use Checkout\Models\PricingRules\BuyNGetOneFreePricingRule;
use Checkout\Models\PricingRules\MealDealPricingRule;
use Checkout\Models\PricingRules\MultipricedPricingRule;
use Checkout\Models\PricingRules\PricingRule;
use Checkout\Services\CheckoutService;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    public function testCalculateTotalWitEmptyItems(): void
    {
        $pricingRules = new PricingRule();
        $checkout = new CheckoutService($pricingRules);

        $this->assertEquals(0, $checkout->calculateTotal());
    }

    public function testSingleItemCheckout(): void
    {
        $pricingRules = new PricingRule();
        $checkout = new CheckoutService($pricingRules);

        $itemA = new Item('A', 50);
        $checkout->scanItem($itemA);

        $this->assertEquals(50, $checkout->calculateTotal());
    }

    public function testMultipricedItemCheckout(): void
    {
        $pricingRules = new PricingRule();
        $multipricedRule = new MultipricedPricingRule('A', 3, 130);
        $pricingRules->addPricingRule($multipricedRule);

        $checkout = new CheckoutService($pricingRules);

        $itemA = new Item('A', 50);
        $checkout->scanItem($itemA);
        $checkout->scanItem($itemA);
        $checkout->scanItem($itemA);

        $this->assertEquals(130, $checkout->calculateTotal());
    }

    public function testBuyNGetOneFreeItemCheckout(): void
    {
        $pricingRules = new PricingRule();
        $buyNGetOneFreeRule = new BuyNGetOneFreePricingRule('C', 3);
        $pricingRules->addPricingRule($buyNGetOneFreeRule);

        $checkout = new CheckoutService($pricingRules);

        $itemC = new Item('C', 25);
        $checkout->scanItem($itemC);
        $checkout->scanItem($itemC);
        $checkout->scanItem($itemC);
        $checkout->scanItem($itemC);

        $this->assertEquals(75, $checkout->calculateTotal());
    }

    public function testMealDealItemCheckout(): void
    {
        $pricingRules = new PricingRule();
        $mealDealRule = new MealDealPricingRule(['D', 'E'], 300);
        $pricingRules->addPricingRule($mealDealRule);

        $checkout = new CheckoutService($pricingRules);

        $itemD = new Item('D', 150);
        $itemE = new Item('E', 200);
        $itemE2 = new Item('E', 200);
        $checkout->scanItem($itemD);
        $checkout->scanItem($itemE);
        $checkout->scanItem($itemE2);

        $this->assertEquals(300, $checkout->calculateTotal());
    }

    public function testCalculateTotalWithMultipleItems(): void
    {
        $pricingRules = new PricingRule();
        $checkout = new CheckoutService($pricingRules);

        $itemA = new Item('A', 50);
        $itemB = new Item('B', 30);
        $checkout->scanItem($itemA);
        $checkout->scanItem($itemB);

        $this->assertEquals(80, $checkout->calculateTotal());
    }
}