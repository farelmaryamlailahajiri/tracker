<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProfesiImport;

class ImportProfesiCommand extends Command
{
    protected $signature = 'import:profesi {file}';
    protected $description = 'Import data profesi dari file Excel';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import profesi dari file: $file");
        Excel::import(new ProfesiImport, $file);
        $this->info("✅ Import profesi selesai.");
    }
}
