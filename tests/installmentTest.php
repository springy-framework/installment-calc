<?php

use PHPUnit\Framework\TestCase;
use Springy\InstallmentCalc;

class InstallmentTest extends TestCase
{
    public function testBasic()
    {
        $inst = new InstallmentCalc(1000, 1, InstallmentCalc::FORMULA_SIMPLE);

        $this->assertEquals(1000, $inst->getPrincipalAmount());
        $this->assertEquals(1, $inst->getInterestRate());
        $this->assertEquals(InstallmentCalc::FORMULA_SIMPLE, $inst->getFormulaMethod());
    }

    public function testBCB()
    {
        $principal = 1000;
        $r = (1 - pow(1 + 0.01, 12 * -1)) / 0.01;
        $fut = round(round($principal / $r, 2) * 12, 2);

        $inst = new InstallmentCalc($principal, 1, InstallmentCalc::FORMULA_BCB);

        $this->assertEquals($fut, $inst->getFutureAmount(12));
        $this->assertEquals($fut - $principal, $inst->getInterest(12));
        $this->assertEquals(round($fut / 12, 2), $inst->getMonthlyInstallment(12));
    }

    public function testCompoundInterest()
    {
        $principal = 1000;
        $fut = round($principal * pow(1 + 0.01, 12), 2);

        $inst = new InstallmentCalc($principal, 1, InstallmentCalc::FORMULA_COMPOUND);

        $this->assertEquals($fut, $inst->getFutureAmount(12));
        $this->assertEquals($fut - $principal, $inst->getInterest(12));
        $this->assertEquals(round($fut / 12, 2), $inst->getMonthlyInstallment(12));
    }

    public function testSimpleInterest()
    {
        $principal = 1000;
        $fut = round($principal + $principal * 0.01 * 12, 2);

        $inst = new InstallmentCalc($principal, 1, InstallmentCalc::FORMULA_SIMPLE);

        $this->assertEquals($fut, $inst->getFutureAmount(12));
        $this->assertEquals($fut - $principal, $inst->getInterest(12));
        $this->assertEquals(round($fut / 12, 2), $inst->getMonthlyInstallment(12));
    }

    public function testSetAmount()
    {
        $inst = new InstallmentCalc(1000);
        $inst->setPrincipalAmount(1999.99);

        $this->assertEquals(1999.99, $inst->getPrincipalAmount());
    }

    public function testSetFormulaMethod()
    {
        $inst = new InstallmentCalc(1000);
        $inst->setFormulaMethod(InstallmentCalc::FORMULA_SIMPLE);

        $this->assertEquals(InstallmentCalc::FORMULA_SIMPLE, $inst->getFormulaMethod());
    }

    public function testSetInterestRate()
    {
        $inst = new InstallmentCalc(1000);
        $inst->setInteresRate(1.99);

        $this->assertEquals(1.99, $inst->getInterestRate());
    }
}
