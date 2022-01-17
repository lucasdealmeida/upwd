<?php

namespace Tests\Feature\Jobs;

use App\DTO\CreditCardDTO;
use App\DTO\UserDTO;
use App\Jobs\InsertRowJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InsertRowJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_insert_on_database_the_user()
    {
        Carbon::setTestNow('2022-01-17 10:00:00');

        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setType('Visa');
        $creditCardDTO->setNumber('1111 2222');
        $creditCardDTO->setName('John D.');
        $creditCardDTO->setExpirationDate('10/29');

        $userDTO = new UserDTO();
        $userDTO->setName('John Doe');
        $userDTO->setAddress('123 Street');
        $userDTO->setChecked(true);
        $userDTO->setDescription('lorem ipsum');
        $userDTO->setInterest('interest');
        $userDTO->setDob('15/05/1987');
        $userDTO->setEmail('john@doe.com');
        $userDTO->setAccount('112233');
        $userDTO->setCreditCard($creditCardDTO);

        (new InsertRowJob($userDTO))->handle();

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'address' => '123 Street',
            'is_checked' => 1,
            'description' => 'lorem ipsum',
            'interest' => 'interest',
            'dob' => '1987-05-15 10:00:00',
            'email' => 'john@doe.com',
            'account' => '112233',
        ]);

        $this->assertDatabaseHas('user_credit_cards', [
            'type' => 'Visa',
            'number' => '1111 2222',
            'name' => 'John D.',
            'expiration_date' => '10/29',
        ]);
    }

    /** @test */
    public function it_should_not_insert_on_database_when_user_already_exists()
    {
        Carbon::setTestNow('2022-01-17 10:00:00');

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'account' => '112233',
        ]);

        $creditCardDTO = new CreditCardDTO();
        $creditCardDTO->setType('Visa');
        $creditCardDTO->setNumber('1111 2222');
        $creditCardDTO->setName('John D.');
        $creditCardDTO->setExpirationDate('10/29');

        $userDTO = new UserDTO();
        $userDTO->setName('John Doe');
        $userDTO->setAddress('123 Street');
        $userDTO->setChecked(true);
        $userDTO->setDescription('lorem ipsum');
        $userDTO->setInterest('interest');
        $userDTO->setDob('15/05/1987');
        $userDTO->setEmail('john@doe.com');
        $userDTO->setAccount('112233');
        $userDTO->setCreditCard($creditCardDTO);

        (new InsertRowJob($userDTO))->handle();

        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'address' => '123 Street',
            'is_checked' => 1,
            'description' => 'lorem ipsum',
            'interest' => 'interest',
            'dob' => '1987-05-15 10:00:00',
            'email' => 'john@doe.com',
            'account' => '112233',
        ]);

        $this->assertDatabaseHas('user_credit_cards', [
            'type' => 'Visa',
            'number' => '1111 2222',
            'name' => 'John D.',
            'expiration_date' => '10/29',
        ]);
    }
}
