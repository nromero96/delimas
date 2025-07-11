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
use App\Http\Controllers\LandingPageSettingController;

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


Route::get('/', [LandingPageSettingController::class, 'viewPage'])->name('viewPageLanding');

// Route::get('/libro-de-reclamaciones', function () {
//     return view('libro-reclamaciones/index');
// })->name('libro-de-reclamaciones');

Route::post('/enviar-reclamo', [PlanrequestController::class, 'sendReclamo'])->name('enviar-reclamo');

Route::get('/mi-cuenta', function () {
    return view('auth/login');
});

//Listar planes
Route::get('list-healthplans', [LandingPageSettingController::class, 'getListHealthPlans'])->name('listhealthplans');

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

    //Optimize
    Route::get('/optimize', function () {
        Artisan::call('optimize');
        return 'Optimizado.';
    });

    //Cache todo
    Route::get('/cache-todo', function () {
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        // Artisan::call('livewire:discover');
        return 'Cache todo.';
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

    Route::get('landing-setting', [LandingPageSettingController::class, 'index'])->name('landingsetting');
    Route::post('landing-setting-save-menu', [LandingPageSettingController::class, 'saveMenu'])->name('landingsetting.save.menu');
    Route::post('landing-setting-save-healthplans', [LandingPageSettingController::class, 'saveHealthPlans'])->name('landingsetting.save.healthplans');

    Route::get('list-request', [PlanrequestController::class, 'index'])->name('listrequest');
    Route::get('show-request/{id}', [PlanrequestController::class, 'show'])->name('showrequest');
    Route::post('update-request-status/{id}', [PlanrequestController::class, 'updateStatus'])->name('updaterequeststatus');

});











Route::get('/prueba', function () {
    return view('layouts/maintemplate');
});
