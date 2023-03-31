<?php

namespace App\Imports;

use App\\ReportCuti;
use Maatwebsite\Excel\Concerns\ToModel;

class ReportCutiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ReportCuti([
            //
        ]);
    }
}
