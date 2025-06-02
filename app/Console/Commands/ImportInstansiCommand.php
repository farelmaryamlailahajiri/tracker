<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InstansiImport;

class ImportInstansiCommand extends Command
{
    protected $signature = 'import:instansi {file}';
    protected $description = 'Import data instansi dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import instansi dari file: $file");
        Excel::import(new InstansiImport, $file);
        $this->info("✅ Import instansi selesai.");
    }
}
