<?php

namespace App\Exports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return JobVacancy::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Company',
            'Location',
            'Description',
            'Requirements',
            'Type',
            'Salary',
            'Logo',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param mixed $job
     * @return array
     */
    public function map($job): array
    {
        return [
            $job->id,
            $job->title,
            $job->company,
            $job->location,
            $job->description,
            $job->requirements,
            $job->type,
            $job->salary,
            $job->logo,
            $job->created_at,
            $job->updated_at,
        ];
    }
}
