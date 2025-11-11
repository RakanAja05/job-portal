<?php

namespace App\Exports;

use App\Models\JobVacancy;
use App\Models\Application;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JobsWithApplicationsExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        // Sheet 1: All Jobs
        $sheets[] = new JobsExport();
        
        // Sheet 2: All Applications
        $sheets[] = new ApplicationsExport();
        
        return $sheets;
    }
}
