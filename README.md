## Checkout

## Setup Instructions

> Requirements
> - PHP >= 8.1
> - Composer >= 2.4.3

**Step 1:** Clone the repository in your terminal using `https://github.com/victorive/checkout.git`

**Step 2:** Navigate to the project’s directory using `cd checkout`

**Step 3:** Run `composer install` to install the project’s dependencies.

### Running the Sample Scenario

Run `php index.php` to execute a sample scenario using the Multipriced pricing rule.

### Running Tests

Run `./vendor/bin/phpunit tests/CheckoutTest.php` to execute the test suites.

### Code Overview

The sample scenario in `index.php` demonstrates how to use the checkout system with various pricing rules. The code creates a `CheckoutService` instance, adds pricing rules, and scans items to calculate the total cost.

## Pricing Rules

The system supports the following pricing rules:

### MultipricedPricingRule

Applies a discount for multiple items of the same type.

### BuyNGetOneFreePricingRule

Applies a "buy one get one free" discount for a specific item.

### MealDealPricingRule

Applies a discount for a set of items purchased together.

### Sample Usage

Here's an example of how to use the checkout system:
```php
<?php

require './vendor/autoload.php';

use Checkout\Models\Item;
use Checkout\Models\PricingRules\MultipricedPricingRule;
use Checkout\Models\PricingRules\PricingRule;
use Checkout\Services\CheckoutService;

$pricingRules = new PricingRule();

//Buy 2 B's for £1.25
$pricingRules->addPricingRule(new MultipricedPricingRule('B', 2, 125));
$checkout = new CheckoutService($pricingRules);

$item1 = new Item('B', 75);
$item2 = new Item('A', 50);
$item3 = new Item('B', 75);

// Scan items
$checkout->scanItem($item1);
$checkout->scanItem($item2);
$checkout->scanItem($item3);

echo number_format(($checkout->calculateTotal() / 100), 2); //Output: 1.75
