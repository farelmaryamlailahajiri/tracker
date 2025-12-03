<?php

// Command untuk import instansi
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InstansiImportFromSurvey;

class ImportInstansiFromSurveyCommand extends Command
{
    protected $signature = 'import:instansi-from-survey {file}';
    protected $description = 'Import data Instansi dari file Survey Pengguna Lulusan';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return;
        }

        $this->info("📦 Memulai import instansi dari file: $file");
        Excel::import(new InstansiImportFromSurvey, $file);
        $this->info("✅ Import instansi selesai.");
    }
}
