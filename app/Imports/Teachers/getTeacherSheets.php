<?php

namespace App\Imports\Teachers;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class getTeacherSheets implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // First sheet
        $sheets[] = new \App\Imports\Teachers\Sheet1Import();

        return $sheets;
    }
}
