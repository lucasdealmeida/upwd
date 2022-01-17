<?php

namespace App\DTO;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Str;

class UserDTO
{
    private string $name;

    private string $address;

    private bool $checked;

    private string $description;

    private ?string $interest;

    private ?CarbonInterface $dob;

    private string $email;

    private string $account;

    private CreditCardDTO $creditCard;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): void
    {
        $this->interest = $interest;
    }

    public function getDob(): ?CarbonInterface
    {
        return $this->dob;
    }

    public function setDob(?string $dob): void
    {
        if (is_null($dob)){
            $this->dob = null;

            return;
        }

        if (Str::contains($dob, '/')) {
            $this->dob = Carbon::createFromFormat('d/m/Y', Str::before($dob, ' '));

            return;
        }

        $this->dob = Carbon::parse($dob);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    public function getCreditCard(): CreditCardDTO
    {
        return $this->creditCard;
    }

    public function setCreditCard(CreditCardDTO $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

}
