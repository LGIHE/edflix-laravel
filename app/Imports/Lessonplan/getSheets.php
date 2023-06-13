<?php

namespace App\Imports\Lessonplan;

use App\Imports\Lessonplan\Sheet1Import;
use App\Imports\Lessonplan\Sheet2Import;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class getSheets implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // First sheet
        $sheets[] = new Sheet1Import();

        // Second sheet
        $sheets[] = new Sheet2Import();

        return $sheets;
    }
}
