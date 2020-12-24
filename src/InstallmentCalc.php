<?php

/**
 * PHP Installment Interest and Future Value Calculator.
 *
 * @copyright 2020 Fernando Val
 * @copyright 2020 Springy Framework Team
 * @author    Fernando Val
 * @license   https://github.com/springy-framework/installment-calc/blob/main/LICENSE MIT
 *
 * @version   1.0.0
 */

namespace Springy;

use Exception;

/**
 * Springy\InstallmentCalc class.
 */
class InstallmentCalc
{
    /** @var float Principal amount */
    protected $principal;
    /** @var float Monthly interest rate */
    protected $interestRate;
    /** @var int Compute method */
    protected $method;

    public const FORMULA_BCB = 1;
    public const FORMULA_SIMPLE = 2;
    public const FORMULA_COMPOUND = 3;

    public function __construct(
        float $value,
        float $instertRate = 0,
        int $method = self::FORMULA_BCB
    ) {
        $this->principal = $value;
        $this->interestRate = $instertRate;
        $this->method = $method;
    }

    /**
     * Computes the installment value using BCB's formula.
     *
     * r = (1 - (1 + j)^(-n)) / j
     * P = r * p
     * p = P / r
     * F = p * n
     *
     * * n = months
     * * j = monthly interest rate percent
     * * P = installment value
     *
     * @see https://www3.bcb.gov.br/CALCIDADAO/publico/exibirMetodologiaFinanciamentoPrestacoesFixas.do?method=exibirMetodologiaFinanciamentoPrestacoesFixas
     *
     * @param int $months
     *
     * @return float
     */
    protected function calcBCB(int $months): float
    {
        $rate = $this->interestRate / 100;
        $res = (1 - pow(1 + $rate, $months * -1)) / $rate;
        $interest = round($this->principal / $res, 2);

        return round($interest * $months, 2);
    }

    /**
     * Computes the installment value using compound interest rate formula.
     *
     * F = P * (1 + i)^n
     *
     * * n = months
     * * j = monthly interest rate percent
     * * p = installment value
     *
     * @param int $months
     *
     * @return float
     */
    protected function calcCompoundInterest(int $months)
    {
        $rate = $this->interestRate / 100;

        return round($this->principal * pow(1 + $rate, $months), 2);
    }

    /**
     * Computes the installment value using simple interest rate formula.
     *
     * F = P + P * j * n
     *
     * * n = months
     * * j = monthly interest rate percent
     * * P = principal value
     *
     * @param int $months
     *
     * @return float
     */
    protected function calcSimpleInterest(int $months)
    {
        $rate = $this->interestRate / 100;
        $interest = $this->principal * $rate * $months;

        return round($this->principal + $interest, 2);
    }

    /**
     * Returns formula method defined.
     *
     * @return int
     */
    public function getFormulaMethod(): int
    {
        return $this->method;
    }

    /**
     * Returns future amount.
     *
     * @param int $months the number of months.
     *
     * @return float
     */
    public function getFutureAmount(int $months): float
    {
        if ($this->method == self::FORMULA_BCB) {
            return $this->calcBCB($months);
        } elseif ($this->method == self::FORMULA_COMPOUND) {
            return $this->calcCompoundInterest($months);
        }

        return $this->calcSimpleInterest($months);
    }

    /**
     * Returns monthly installment value.
     *
     * @param int $months the number of months.
     *
     * @return float
     */
    public function getMonthlyInstallment(int $months): float
    {
        return round($this->getFutureAmount($months) / $months, 2);
    }

    /**
     * Returns total interest value.
     *
     * @param int $months the number of months.
     *
     * @return float
     */
    public function getInterest(int $months): float
    {
        return round($this->getFutureAmount($months) - $this->principal, 2);
    }

    /**
     * Returns current interest rate.
     *
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    /**
     * Returns the principal amount.
     *
     * @return float
     */
    public function getPrincipalAmount(): float
    {
        return $this->principal;
    }

    /**
     * Sets the formula method.
     *
     * @param int $method
     *
     * @return void
     */
    public function setFormulaMethod(int $method): void
    {
        if (!in_array($method, [self::FORMULA_BCB, self::FORMULA_COMPOUND, self::FORMULA_SIMPLE])) {
            throw new Exception('Invalid formula method', E_USER_ERROR);
        }

        $this->method = $method;
    }

    /**
     * Sets the interest rate.
     *
     * @param float $interest
     *
     * @return void
     */
    public function setInteresRate(float $interest): void
    {
        $this->interestRate = $interest;
    }

    /**
     * Sets the principal amount.
     *
     * @param float $value
     *
     * @return void
     */
    public function setPrincipalAmount(float $value): void
    {
        $this->principal = $value;
    }
}
