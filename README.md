# PHP Installment Interest and Future Value Calculator

This class can calculate the amount of installments on loans.

It can take as parameters the loan amount, the interest rate and the
identification of the method to use to calculate the installments.

The class can returns the values related with installment payments like the
total amount or the interest amount to be returned after a given number of
months.

[![Latest Stable Version](https://poser.pugx.org/springy-framework/installment-calc/v/stable)](https://packagist.org/packages/springy-framework/installment-calc)
[![tests](https://github.com/springy-framework/installment-calc/actions/workflows/php.yml/badge.svg)](https://github.com/springy-framework/installment-calc/actions/workflows/php.yml)
[![Build Status](https://travis-ci.com/springy-framework/installment-calc.svg?branch=main)](https://travis-ci.com/springy-framework/installment-calc)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![StyleCI](https://github.styleci.io/repos/323458954/shield?style=flat)](https://github.styleci.io/repos/323458954)
[![Total Downloads](https://poser.pugx.org/springy-framework/installment-calc/downloads)](https://packagist.org/packages/springy-framework/installment-calc)
[![License](https://poser.pugx.org/springy-framework/installment-calc/license)](https://packagist.org/packages/springy-framework/installment-calc)

## Requirements

- PHP 7.3+

## Instalation

To get the latest stable version of this component use:

```json
"require": {
    "springy-framework/installment-calc": "*"
}
```

in your composer.json file.

## Usage

I suppose that the following example is all you need:

```php
<?php

require 'vendor/autoload.php'; // If you're using Composer (recommended)

// Creates the object. Only the principal value is requered in constructor.
$installment = new Springy\InstallmentCalc(
    1000,
    0.5,
    Springy\InstallmentCalc::FORMULA_COMPOUND
);

/*
    Interst formula constants explained

    Springy\InstallmentCalc::FORMULA_SIMPLE - Simple interest
    Springy\InstallmentCalc::FORMULA_COMPOUND - Compound interest
    Springy\InstallmentCalc::FORMULA_BCB - Brazilian Central Bank interset formula
*/


// Gets future amount for 12 months
echo $installment->getFutureAmount(12);

// Gets total interest for 12 months
echo $installment->getInterest(12);

// Gets monthly installment for 12 months
echo $installment->getMonthlyInstallment(12);

// Gets current principal amount
echo $installment->getPrincipalAmount();

// Gets current interest formula method
echo $installment->getFormulaMethod();

// Gets current interes rate
echo $installment->getInterestRate();

// Changes the principal amount value
$installment->setPrincipalAmount(1999.99);

// Changes the interest formula value
$installment->setFormulaMethod(Springy\InstallmentCalc::FORMULA_SIMPLE);

// Changes the interest rate value
$installment->setInteresRate(1.99);
```

## Contributing

Please read our [contributing](/CONTRIBUTING.md) document and thank you for
doing that.

## Code of Conduct

In order to ensure that our community is welcoming to all, please review and
abide by the [code of conduct](/CODE_OF_CONDUCT.md).

## License

This project is licensed under [The MIT License (MIT)](/LICENSE).
