<?php
namespace App\Services\Taxes;

class VatTax implements TaxCalculatorInterface
{
    public function calculate(float $amount): float
    {
        return $amount * 0.15;
    }
}
