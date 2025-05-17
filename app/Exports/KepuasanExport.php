<?php

namespace App\Exports;

use App\Models\Kepuasan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KepuasanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kepuasan::all();
    }
}
