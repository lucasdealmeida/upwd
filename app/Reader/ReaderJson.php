<?php

namespace App\Reader;

use App\DTO\CreditCardDTO;
use App\DTO\UserDTO;
use Illuminate\Support\LazyCollection;

class ReaderJson extends ReaderContract
{
    public function readFile(): LazyCollection
    {
        return LazyCollection::make(function (){
            $json = file_get_contents($this->filePath);

            $data = json_decode($json,true);

            foreach ($data as $row) {
                $creditCardDTO = new CreditCardDTO();
                $creditCardDTO->setType($row['credit_card']['type']);
                $creditCardDTO->setNumber($row['credit_card']['number']);
                $creditCardDTO->setName($row['credit_card']['name']);
                $creditCardDTO->setExpirationDate($row['credit_card']['expirationDate']);

                $userDTO = new UserDTO();
                $userDTO->setName($row['name']);
                $userDTO->setAddress($row['address']);
                $userDTO->setChecked($row['checked']);
                $userDTO->setDescription($row['description']);
                $userDTO->setInterest($row['interest']);
                $userDTO->setDob($row['date_of_birth']);
                $userDTO->setEmail($row['email']);
                $userDTO->setAccount($row['account']);
                $userDTO->setCreditCard($creditCardDTO);

                yield $userDTO;
            }
        });
    }
}
