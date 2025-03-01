<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupTempImages extends Command
{
    protected $signature = 'cleanup:temp-images';
    protected $description = 'Menghapus gambar sementara yang lebih dari 1 hari di folder temp';

    public function handle()
    {
        $files = Storage::files('public/temp');

        foreach ($files as $file) {
            $lastModified = Storage::lastModified($file);
            if ($lastModified < now()->subDay()->timestamp) {
                Storage::delete($file);
                $this->info("Deleted: " . $file);
            }
        }
    }
}