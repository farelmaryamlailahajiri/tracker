<?php

namespace App\Exports;

use App\Models\Lulusan;
use Maatwebsite\Excel\Concerns\FromCollection;

class TracerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lulusan::all();
    }
}
