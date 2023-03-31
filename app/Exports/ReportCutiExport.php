<?php

namespace App\Exports;

use App\\ReportCuti;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportCutiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReportCuti::all();
    }
}
