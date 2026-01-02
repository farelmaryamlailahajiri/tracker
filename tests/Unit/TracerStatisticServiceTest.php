<?php

namespace Tests\Unit;

use App\Services\TracerStatisticService;
use Tests\TestCase;

class TracerStatisticServiceTest extends TestCase
{
    public function test_hitung_response_rate_normal()
    {
        $service = new TracerStatisticService();

        $result = $service->hitungResponseRate(50, 100);

        $this->assertEquals(50.00, $result);
    }

    public function test_hitung_response_rate_jika_jumlah_lulusan_nol()
    {
        $service = new TracerStatisticService();

        $result = $service->hitungResponseRate(10, 0);

        $this->assertEquals(0, $result);
    }
}
