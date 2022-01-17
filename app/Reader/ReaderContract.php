<?php

namespace App\Reader;

use Illuminate\Support\LazyCollection;

abstract class ReaderContract
{
    protected string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    abstract function readFile(): LazyCollection;
}
