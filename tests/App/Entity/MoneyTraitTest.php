<?php

class Money
{
    use App\Entity\MoneyTrait;
}

class MoneyTraitTest extends PHPUnit_Framework_TestCase
{
    public function testMoneyIsEqual()
    {
        $this->assertTrue(Money::eq(0, 0.00));
        $this->assertFalse(Money::eq(0, 0.01));
        $this->assertFalse(Money::eq(0.01, 0));

        // rounding
        $this->assertTrue(Money::eq(0, 0.004));
        $this->assertTrue(Money::eq(0, 0.005));
        $this->assertTrue(Money::eq(0.004, 0));
        $this->assertTrue(Money::eq(0.005, 0));
    }

    public function testMoneyIsGreater()
    {
        $this->assertFalse(Money::gt(0, 0.00));
        $this->assertTrue(Money::gt(0.01, 0));
        $this->assertFalse(Money::gt(0, 0.01));

        // rounding
        $this->assertFalse(Money::gt(0.004, 0));
        $this->assertFalse(Money::gt(0.005, 0));
    }

    public function testMoneyIsLesser()
    {
        $this->assertFalse(Money::lt(0, 0.00));
        $this->assertFalse(Money::lt(0.01, 0));
        $this->assertTrue(Money::lt(0, 0.01));

        // rounding
        $this->assertFalse(Money::lt(0, 0.004));
        $this->assertFalse(Money::lt(0, 0.005));
    }

    public function testRoundingDown()
    {
        $this->assertEquals(1.00, Money::round(1.001), 0.01);
        $this->assertEquals(1.00, Money::round(1.005), 0.01);
        $this->assertEquals(1.00, Money::round(1.009), 0.01);
    }
}
