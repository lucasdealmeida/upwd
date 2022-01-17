<?php

namespace App\Jobs;

use App\DTO\CreditCardDTO;
use App\DTO\UserDTO;
use App\Models\User;
use App\Reader\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ReaderFactory::get($this->filePath)
            ->readFile()
            ->each(function(UserDTO $userDTO) {
                if ($this->shouldStore($userDTO)) {
                    InsertRowJob::dispatch($userDTO);
                }
            });
    }

    protected function shouldStore(UserDTO $userDTO): bool
    {
        if ($userDTO->getDob() === null) {
            return true;
        }

        if (
            $userDTO->getDob()->lessThan(Carbon::now()->subYears(18))
            && $userDTO->getDob()->greaterThan(Carbon::now()->subYears(65))
        ){
            return true;
        }

        /**
         * Suppose that only records need to be processed for which the credit card
         * number contains three consecutive same digits, how would you handle that?
         */
        preg_match('/(.)\1{2,}/', $userDTO->getCreditCard()->getNumber(), $output);
        if (count($output) > 0) {
            return true;
        }

        return false;
    }
}
