<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TracerImport;

class ImportTracerCommand extends Command
{
    protected $signature = 'import:tracer {file}';
    protected $description = 'Import data Tracer dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import dari file: $file");
        Excel::import(new TracerImport, $file);
        $this->info("✅ Import selesai.");
    }
}
