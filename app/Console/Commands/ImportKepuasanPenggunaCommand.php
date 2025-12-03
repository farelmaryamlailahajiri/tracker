<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KepuasanPenggunaImport;

class ImportKepuasanPenggunaCommand extends Command
{
    protected $signature = 'import:kepuasan_pengguna {file}';
    protected $description = 'Import data Kepuasan Pengguna dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import dari file: $file");
        Excel::import(new KepuasanPenggunaImport, $file);
        $this->info("✅ Import selesai.");
    }
}
