<?php

namespace Tests\Unit\DTO;

use App\DTO\CreditCardDTO;
use App\DTO\UserDTO;
use PHPUnit\Framework\TestCase;

class UserDTOTest extends TestCase
{
    /** @test */
    public function it_should_set_name_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setName('John Doe');

        $this->assertEquals('John Doe', $userDTO->getName());
    }

    /** @test */
    public function it_should_set_address_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setAddress('123 Street');

        $this->assertEquals('123 Street', $userDTO->getAddress());
    }

    /** @test */
    public function it_should_set_checked_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setChecked(true);
        $this->assertTrue($userDTO->isChecked());

        $userDTO->setChecked(false);
        $this->assertFalse($userDTO->isChecked());
    }

    /** @test */
    public function it_should_set_description_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setDescription('description');

        $this->assertEquals('description', $userDTO->getDescription());
    }

    /** @test */
    public function it_should_set_interest_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setInterest('interest');
        $this->assertEquals('interest', $userDTO->getInterest());

        $userDTO->setInterest(null);
        $this->assertNull($userDTO->getInterest());
    }

    /** @test */
    public function it_should_set_date_of_birth_attr()
    {
        $userDTO = new UserDTO();

        $userDTO->setDob('16/02/1998');
        $this->assertEquals('1998-02-16', $userDTO->getDob()->toDateString());

        $userDTO->setDob('1989-03-21T01:11:13+00:00');
        $this->assertEquals('1989-03-21', $userDTO->getDob()->toDateString());

        $userDTO->setDob(null);
        $this->assertNull($userDTO->getDob());
    }

    /** @test */
    public function it_should_set_email_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setEmail('john@doe.com');

        $this->assertEquals('john@doe.com', $userDTO->getEmail());
    }

    /** @test */
    public function it_should_set_account_attr()
    {
        $userDTO = new UserDTO();
        $userDTO->setAccount('123');

        $this->assertEquals('123', $userDTO->getAccount());
    }

    /** @test */
    public function it_should_set_credit_card_attr()
    {
        $creditCartDTO = new CreditCardDTO();

        $userDTO = new UserDTO();
        $userDTO->setCreditCard($creditCartDTO);

        $this->assertEquals($creditCartDTO, $userDTO->getCreditCard());
    }
}
