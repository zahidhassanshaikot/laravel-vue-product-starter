<?php

use App\Http\CommonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', 'login');

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index'] )->name('dashboard');

    Route::get('/load-modal/{page_name}/{param1?}/{param2?}/{param3?}', [CommonController::class, 'loadModal'])->name('load-modal')->where('param1', '(.*)');
    Route::get('/app-language-change/{lang}', [CommonController::class, 'changeLanguage'])->name('app.language.change');


    Route::resource('users',UserController::class);
    Route::resource('settings', SettingController::class)->only(['index', 'store']);
    Route::resource('roles', RoleController::class);
    Route::post('users/bulk-delete', [UserController::class, 'bulk_destroy'])->name('users.bulk-destroy');

    Route::resource('students', StudentController::class);
});

require __DIR__.'/auth.php';
