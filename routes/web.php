<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

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

//Authentication
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name("register");
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'create']);
Route::get('/forget-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])
    ->name('forget.password.get');
Route::post('/forget-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgetPasswordForm'])
    ->name('forget.password.post');
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])
    ->name('reset.password.get');
Route::post('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])
    ->name('reset.password.post');

// Página principal del sitio
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Grupo de grupos de rutas
Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });

    Route::group(['prefix' => 'innclod-crud'], function () {

        // GRUPO DE RUTAS PARA MÓDULO DE "PERMISOS"
        Route::group(['prefix' => 'home'], function () {
            Route::post('/permissions', [\App\Http\Controllers\HomeController::class, 'permissions']);
        });

        // GRUPO DE RUTAS PARA MÓDULO DE "SEGUIMIENTOS" (RE NOMBRADO VISUALMENTE)
        Route::group(['prefix' => 'audits'], function () {
            Route::get('/getAudits', [\App\Http\Controllers\AuditController::class, 'getAudits']);
            Route::post('/generateReport', [\App\Http\Controllers\AuditController::class, 'generateReport']);
        });

        // GRUPO DE RUTAS PARA MÓDULO DE "DELEGACIONES"
        Route::group(['prefix' => 'delegations'], function () {
            Route::get('/getDelegations', [\App\Http\Controllers\DelegationController::class, 'getDelegations']);
        });

        Route::group(['prefix' => 'processes'], function () {
            Route::get('/getProcesses', [\App\Http\Controllers\ProProcesoController::class, 'getProcesses']);
            Route::get('/getProcessesFilter', [\App\Http\Controllers\ProProcesoController::class, 'getProcessesFilter']);
            Route::get('/getProcessPrefix', [\App\Http\Controllers\ProProcesoController::class, 'getProcessPrefix']);
        });

        Route::group(['prefix' => 'types'], function () {
            Route::get('/getTypes', [\App\Http\Controllers\TipTipoController::class, 'getTypes']);
            Route::get('/getTypesFilter', [\App\Http\Controllers\TipTipoController::class, 'getTypesFilter']);
            Route::get('/getTypePrefix', [\App\Http\Controllers\TipTipoController::class, 'getTypePrefix']);
        });

        Route::group(['prefix' => 'documents'], function () {
            Route::get('/getDocuments', [\App\Http\Controllers\DocDocumentoController::class, 'getDocuments']);
            Route::get('/getCountDocuments', [\App\Http\Controllers\DocDocumentoController::class, 'getCountDocuments']);
            Route::post('/store', [\App\Http\Controllers\DocDocumentoController::class, 'store']);
            Route::get('/show/{doc_document}', [\App\Http\Controllers\DocDocumentoController::class, 'show']);
            Route::post('/{doc_document}/update', [\App\Http\Controllers\DocDocumentoController::class, 'update']);
            Route::delete('/{doc_document}/destroy', [\App\Http\Controllers\DocDocumentoController::class, 'destroy']);

        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/getUsers', [\App\Http\Controllers\UserController::class, 'getUsers']);
            Route::get('/getRoles', [\App\Http\Controllers\UserController::class, 'getRoles']);
            Route::post('/store', [\App\Http\Controllers\UserController::class, 'store']);
            Route::post('/{user}/update', [\App\Http\Controllers\UserController::class, 'update']);
            Route::post('/importUsers', [\App\Http\Controllers\UserController::class, 'importUsers'])->name('users.import');
            Route::post('/{user}/photoUpload', [\App\Http\Controllers\UserController::class, 'photoUpload']);
            Route::put('/updatePassword', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('updatePassword');
            Route::get('/searchUser', [\App\Http\Controllers\UserController::class, 'searchUser'])->name('searchUser');
            Route::get('/usersSelectPassword', [\App\Http\Controllers\UserController::class, 'usersSelectPassword'])->name('usersSelectPassword');

        });
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->to('/v/home');
})->name('dashboard');

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/v/{any?}/{any1?}/{any2?}/{any3?}/{any4?}', function ($any = null, $any1 = null, $any2 = null, $any3 = null, $any4 = null) {
    return view('layouts.coreui');
})->where('vue', '.*')->name('rutas.vue');
