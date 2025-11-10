<?php

namespace App\Imports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new JobVacancy([
            'title'        => $row['title'],
            'company'      => $row['company'],
            'location'     => $row['location'],
            'description'  => $row['description'],
            'requirements' => $row['requirements'] ?? null,
            'type'         => $row['type'] ?? 'full-time',
            'salary'       => $row['salary'] ?? null,
            'logo'         => $row['logo'] ?? null,
        ]);
    }
}

