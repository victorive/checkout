<?php

namespace Checkout\Interfaces;

interface ItemInterface
{
    public function getSku(): string;
    public function getUnitPrice();
}