<?php

namespace Tests\Unit\DTO;

use App\DTO\CreditCardDTO;
use PHPUnit\Framework\TestCase;

class CreditCardDTOTest extends TestCase
{
    /** @test */
    public function it_should_set_type_attr()
    {
        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setType('Visa');

        $this->assertEquals('Visa', $creditCardDTO->getType());
    }

    /** @test */
    public function it_should_set_number_attr()
    {
        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setNumber('1111 2222');

        $this->assertEquals('1111 2222', $creditCardDTO->getNumber());
    }

    /** @test */
    public function it_should_set_name_attr()
    {
        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setName('John Doe');

        $this->assertEquals('John Doe', $creditCardDTO->getName());
    }

    /** @test */
    public function it_should_set_expiration_date_attr()
    {
        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setExpirationDate('01/25');

        $this->assertEquals('01/25', $creditCardDTO->getExpirationDate());
    }
}
