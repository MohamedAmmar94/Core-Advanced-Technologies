<?php
namespace App\Services\Taxes;

class TaxService
{
    /**
     * @param TaxCalculatorInterface[] $taxCalculators
     */
    public function __construct(
        private array $taxCalculators
    ) {}

    public function calculateTotal(float $amount): float
    {
        $totalTax = 0.0;

        foreach ($this->taxCalculators as $calculator) {
            $totalTax += $calculator->calculate($amount);
        }

        return $totalTax;
    }
}
