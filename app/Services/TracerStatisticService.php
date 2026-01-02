<?php

namespace App\Services;

class TracerStatisticService
{
    public function hitungResponseRate(int $jumlahResponden, int $jumlahLulusan): float
    {
        if ($jumlahLulusan === 0) {
            return 0;
        }

        return round(($jumlahResponden / $jumlahLulusan) * 100, 2);
    }
}
