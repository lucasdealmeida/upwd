<?php

namespace Tests\Feature\Jobs;

use App\Jobs\InsertRowJob;
use App\Jobs\ReadFileJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReadFileJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_push_insert_row_job_to_queue()
    {
        Queue::fake();

        $filePath = 'tests/fixtures/challenge.json';

        (new ReadFileJob($filePath))->handle();

        Queue::assertPushed(function (InsertRowJob $job) {
            $this->assertEquals('John Doe', $job->userDTO->getName());
            $this->assertEquals('328 Bergstrom', $job->userDTO->getAddress());
            $this->assertFalse($job->userDTO->isChecked());
            $this->assertEquals('Voluptatibus nihil', $job->userDTO->getDescription());
            $this->assertNull($job->userDTO->getInterest());
            $this->assertEquals('1989-03-21', $job->userDTO->getDob()->format('Y-m-d'));
            $this->assertEquals('john@doe.net', $job->userDTO->getEmail());
            $this->assertEquals('112233', $job->userDTO->getAccount());

            $this->assertEquals('Visa', $job->userDTO->getCreditCard()->getType());
            $this->assertEquals('4532383564703', $job->userDTO->getCreditCard()->getNumber());
            $this->assertEquals('Brooks Hudson', $job->userDTO->getCreditCard()->getName());
            $this->assertEquals('12/19', $job->userDTO->getCreditCard()->getExpirationDate());

            return true;
        });
    }

    /** @test */
    public function it_should_not_push_insert_row_job_to_queue_when_user_is_less_then_18_years_old()
    {
        Queue::fake();

        $filePath = 'tests/fixtures/challenge2.json';

        (new ReadFileJob($filePath))->handle();

        Queue::assertNotPushed(InsertRowJob::class);
    }

    /** @test */
    public function it_should_not_push_insert_row_job_to_queue_when_user_is_more_then_65_years_old()
    {
        Queue::fake();

        $filePath = 'tests/fixtures/challenge3.json';

        (new ReadFileJob($filePath))->handle();

        Queue::assertNotPushed(InsertRowJob::class);
    }
}
