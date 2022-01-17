<?php

namespace App\Reader;

use Exception;
use Illuminate\Support\Str;

class ReaderFactory
{
    /**
     * @param string $filePath
     * @return ReaderContract
     * @throws Exception
     */
    public static function get(string $filePath): ReaderContract
    {
        $extension = Str::afterLast($filePath, '.');

        switch ($extension) {
            case 'json':
                return new ReaderJson($filePath);
            default:
                throw new Exception('Reader not implemented.');
        }
    }
}
