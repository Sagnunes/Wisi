<?php

declare(strict_types=1);

namespace App\Helpers;

final class ArrayHelper
{
    public static function chunkFile(string $path, callable $generator, int $chunkSize)
    {
        $file = fopen($path, 'r');
        fgetcsv($file); // skip header
        $data = [];
        for ($ii = 1; ($row = fgetcsv($file, null, ',')) !== false; $ii++) {
            $data[] = $generator($row);

            if ($ii % $chunkSize === 0) {
                yield $data;
                $data = [];
            }
        }

        if ($data !== []) {
            yield $data;
        }
        fclose($file);
    }
}
