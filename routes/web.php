<?php

use App\Http\Controllers\BackupController;

Route::get('/backup', [BackupController::class, 'download'])->name('backup.download');
