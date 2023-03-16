<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class getSheets implements WithMultipleSheets
{
    public function sheets(): array
    {
        // return [
        //     0 => new Sheet1Import,
        //     1 => new Sheet2Import,
        // ];

        $sheets = [];

        // First sheet
        $sheets[] = new Sheet1Import();

        // Second sheet
        $sheets[] = new Sheet2Import();

        return $sheets;
    }
}
