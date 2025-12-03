<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;

class ImportAlumniCommand extends Command
{
    protected $signature = 'import:alumni {file}';
    protected $description = 'Import data Alumni dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import dari file: $file");
        Excel::import(new AlumniImport, $file);
        $this->info("✅ Import selesai.");
    }
}
