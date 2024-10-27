<?php

use Illuminate\Support\Facades\Route;

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

