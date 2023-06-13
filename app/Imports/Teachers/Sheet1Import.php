<?php

namespace App\Imports\Teachers;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\requiredInLPUpload;
use App\Models\User;

class Sheet1Import implements ToCollection, WithHeadingRow
{

    /**
    * @param array $row
    *
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.name' => new requiredInLPUpload('name'),
            '*.school' => new requiredInLPUpload('school'),
            '*.gender' => new requiredInLPUpload('gender'),
            '*.subject1' => new requiredInLPUpload('subject'),
            '*.address' => new requiredInLPUpload('address'),
        ])->validate();

        $users = [];

        foreach ($rows as $row) {
            $user = User::create([
                'role' => 'Teacher',
                'type' => 'teacher',
                'name' => $row['name'],
                'school' => $row['school'],
                'gender' => $row['gender'],
                'subject_1' => $row['subject1'],
                'subject_2' => $row['subject2'],
                'subject_3' => $row['subject3'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'location' => $row['address'],
                'password' => $row['password'],
                'created_by' => auth()->user()->id,
            ]);

            $users[] = $user;
        }

        return $users;
    }


}
