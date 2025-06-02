<?php

// Command untuk import profesi
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProfesiImportFromSurvey;

class ImportProfesiFromSurveyCommand extends Command
{
    protected $signature = 'import:profesi-from-survey {file}';
    protected $description = 'Import data Profesi dari file Survey Pengguna Lulusan';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import profesi dari file: $file");
        Excel::import(new ProfesiImportFromSurvey, $file);
        $this->info("✅ Import profesi selesai.");
    }
}
