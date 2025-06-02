<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenggunaLulusanImport;

class ImportPenggunaLulusanCommand extends Command
{
    protected $signature = 'import:pengguna-lulusan {file}';
    protected $description = 'Import data pengguna lulusan dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import pengguna lulusan dari file: $file");
        Excel::import(new PenggunaLulusanImport, $file);
        $this->info("✅ Import pengguna lulusan selesai.");
    }
}
