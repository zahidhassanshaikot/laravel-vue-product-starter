<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


// backup and download database
Route::get('zhs-db-download', function() {
    \Artisan::call('app:database-backup');
    $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";
    if (file_exists(storage_path() . "/app/backup/" . $filename)) :
        //  download file and delete it
        $gz_file = storage_path() . "/app/backup/" . $filename;
        $gz_file_name = basename($gz_file);
        header("Content-Type: application/gzip");
        header("Content-Disposition: attachment; filename=$gz_file_name");
        header("Content-Length: " . filesize($gz_file));
        readfile($gz_file);
        unlink($gz_file);
    endif;

    echo true;
});
Route::get('artisan/cache', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('config:cache');
    \Artisan::call('route:cache');
    \Artisan::call('view:cache');
    \Artisan::call('optimize');

    sendFlash('Cached successfully');
    echo true;
//    return redirect()->back();
});
Route::get('artisan/cache-clear', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');

//    \Artisan::call('logs:clear');
//    try{
//    \Artisan::call('debugbar:clear');
//    }catch(\Throwable $e){
////        dd($e);
////        echo $e->getMessage();
//    }

    // SESSION_DRIVER=file
    $directory = config('session.files');
    $ignoreFiles = ['.gitignore', '.', '..'];
    $session_files = scandir($directory);

    foreach ($session_files as $session_file) {
        if (!in_array($session_file, $ignoreFiles)) {
            unlink($directory . '/' . $session_file);
        }
    }
    //Debugbar clear
    $debugbarDirectory = storage_path('debugbar');
    $debugbar_files = scandir($debugbarDirectory);

    foreach ($debugbar_files as $debugbar_file) {
        if (!in_array($debugbar_file, $ignoreFiles)) {
            unlink($debugbarDirectory . '/' . $debugbar_file);
        }
    }

//    \Session::flush();
    \Session::getHandler()->gc(0);

    sendFlash('Cache cleared successfully');
    return redirect()->back();
    echo true;
});
Route::get('artisan/migrate', function () {
    \Artisan::call('migrate');
    echo true;
});
Route::get('artisan/db-seed', function () {
    \Artisan::call('db:seed');
    echo true;
});
Route::get('artisan/migrate-fresh-seed', function () {
    \Artisan::call('migrate:fresh --seed');
    echo true;
});
Route::get('artisan/storage-link', function () {
    \Artisan::call('storage:link');
    echo true;
});

