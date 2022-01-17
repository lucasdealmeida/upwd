<?php

namespace App\Jobs;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public UserDTO $userDTO;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserDTO $userDTO)
    {
        $this->userDTO = $userDTO;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::firstOrCreate([
            'name' => $this->userDTO->getName(),
            'email' => $this->userDTO->getEmail(),
            'account' => $this->userDTO->getAccount(),
        ], [
            'address' => $this->userDTO->getAddress(),
            'is_checked' => $this->userDTO->isChecked(),
            'description' => $this->userDTO->getDescription(),
            'interest' => $this->userDTO->getInterest(),
            'dob' => $this->userDTO->getDob(),
        ]);

        $user->creditCard()->create([
            'type' => $this->userDTO->getCreditCard()->getType(),
            'name' => $this->userDTO->getCreditCard()->getName(),
            'number' => $this->userDTO->getCreditCard()->getNumber(),
            'expiration_date' => $this->userDTO->getCreditCard()->getExpirationDate(),
        ]);
    }
}
