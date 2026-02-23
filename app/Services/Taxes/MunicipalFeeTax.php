<?php
namespace App\Services\Taxes;

class MunicipalFeeTax implements TaxCalculatorInterface
{
    public function calculate(float $amount): float
    {
        return $amount * 0.025;
    }
}
