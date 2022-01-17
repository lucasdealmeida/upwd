<?php

namespace Tests\Unit\Reader;

use App\Reader\ReaderFactory;
use App\Reader\ReaderJson;
use PHPUnit\Framework\TestCase;

class ReaderFactoryTest extends TestCase
{
    /** @test */
    public function it_should_return_json_reader()
    {
        $reader = ReaderFactory::get('file.json');
        $this->assertInstanceOf(ReaderJson::class, $reader);
    }

    /** @test */
    public function it_should_throw_an_error_when_reader_does_not_exist()
    {
        $this->expectExceptionMessage('Reader not implemented.');
        ReaderFactory::get('file.doc');
    }
}
