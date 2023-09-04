<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\Backup;

class BackupController extends Controller
{

    public function backup()
    {
        // Create a new backup
        Artisan::call('backup:run');
        // Clean and reset migrations
        Artisan::call('migrate:fresh --seed');
        
        return redirect()->route('backup_notify');
    }

}
