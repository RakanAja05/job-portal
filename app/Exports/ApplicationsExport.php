<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Application::with(['user', 'jobVacancy'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Applicant Name',
            'Applicant Email',
            'Job Title',
            'Company',
            'CV',
            'Status',
            'Applied At',
        ];
    }

    /**
     * @param mixed $application
     * @return array
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->user->name,
            $application->user->email,
            $application->jobVacancy->title,
            $application->jobVacancy->company,
            $application->cv,
            $application->status,
            $application->created_at,
        ];
    }
}
