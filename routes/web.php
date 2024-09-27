<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PlanrequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing-promo/index');
});

Route::get('/mi-cuenta', function () {
    return view('auth/login');
});

//Solicitar pedido
Route::post('/solicitar-pedido', [PlanrequestController::class, 'store'])->name('solicitar-pedido');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    //Ejecutar migración
    Route::get('/ejecutar-migraciones', function () {
        Artisan::call('migrate');
        return 'Migraciones ejecutadas con éxito.';
    });

    //Limpiar cache
    Route::get('/limpiar-cache', function () {
        Artisan::call('cache:clear');
        return 'Cache limpiado con éxito.';
    });

    //storage link
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage link creado correctamente en cpanel.';
    });

    //Route::get('dashboard','App\Http\Controllers\DashboardController')->name('dashboard');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('program','App\Http\Controllers\ProgramController');
    Route::get('destroysinglepp/{id}', [ProgramController::class, 'destroysingleprogramprice'])->name('programs.destroysingleprogramprice');

    Route::resource('customer','App\Http\Controllers\CustomerController');
    Route::get('customershow/{id}', [CustomerController::class, 'showinfocustomer'])->name('customers.showinfocustomer');

    Route::resource('holiday','App\Http\Controllers\HolidayController');
    Route::get('holiday-listholidays', [HolidayController::class, 'getlistholidays'])->name('holidays.holidaylistholidays');

    Route::resource('period','App\Http\Controllers\PeriodController');

    Route::get('deliveriesoftheday', [PeriodController::class, 'deliveriesoftheday'])->name('deliveriesoftheday');
    Route::get('download-stickers', [PeriodController::class, 'downloadStickers'])->name('download-stickers');
    Route::get('download-entry-control', [PeriodController::class, 'downloadEntryControl'])->name('download-entry-control');

    Route::resource('users', 'App\Http\Controllers\UserController');


    Route::resource('districts','App\Http\Controllers\DistrictController');

});











Route::get('/prueba', function () {
    return view('layouts/maintemplate');
});
