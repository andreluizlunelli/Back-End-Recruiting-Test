<?php

namespace LegacyApp;

use Tests\TestCase;

class CreditCardTest extends TestCase
{
    /**
     * @var CreditCard
     */
    private $creditCard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creditCard = new CreditCard();
    }

    public function testValidNumber()
    {
        $cardNumber = '4444333322221111';

        $this->assertTrue($this->creditCard->set($cardNumber));
    }

    public function testInvalidNumberShouldReturError()
    {
        $cardNumber = '3333555522221111';

        $this->assertEquals('ERROR_INVALID_LENGTH', $this->creditCard->set($cardNumber));
    }

    public function testValidNumberShouldSetAndGet()
    {
        $cardNumber = '4444333322221111';

        $this->creditCard->set($cardNumber);

        $expected = '4444333322221111';

        $this->assertEquals($expected, $this->creditCard->get());
    }

    public function testWithSanitizedValue()
    {
        $cardNumber = '4444-3333-2222-1111';

        $this->creditCard->set($cardNumber);

        $expected = '4444333322221111';

        $this->assertEquals($expected, $this->creditCard->get());
    }
}
