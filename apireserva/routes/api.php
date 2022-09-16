<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RolsController;
use App\Http\Controllers\Api\ClinicsController;
use App\Http\Controllers\Api\SpecialtiesController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\PatientsController;
use App\Http\Controllers\Api\ReservationsController;
use App\Http\Controllers\Api\HorariesController;
use App\Http\Controllers\Api\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//         return $request->user();
//});
Route::post('/auth/login',[LoginController::class, 'login']);
Route::get('/auth/me',[LoginController::class, 'me'])->middleware('auth:api');
Route::get('/auth/logout',[LoginController::class, 'logout'])->middleware('auth:api');
Route::post('/auth/register',[LoginController::class, 'register']);

Route::middleware('auth:api')->prefix('/user')->group(function(){
    Route::middleware('auth:api')->get('/all',[UserController::class, 'all']);
});


Route::get('/greeting', function () {
    return 'Hello World';
});

//Route::group([
//    'prefix' => 'rols',
//], function () {
//    Route::get('/', [RolsController::class, 'index'])
//         ->name('api.rols.rol.index');
//    Route::get('/show/{rol}',[RolsController::class, 'show'])
//         ->name('api.rols.rol.show');
//    Route::post('/', [RolsController::class, 'store'])
//         ->name('api.rols.rol.store');
//    Route::put('rol/{rol}', [RolsController::class, 'update'])
//         ->name('api.rols.rol.update');
//    Route::delete('/rol/{rol}',[RolsController::class, 'destroy'])
//         ->name('api.rols.rol.destroy');
//});

Route::middleware('auth:api')->prefix('/clinics')->group(function(){
    Route::get('/', [ClinicsController::class, 'index'])
         ->name('api.clinics.clinic.index');
    Route::get('/show/{clinic}',[ClinicsController::class, 'show'])
         ->name('api.clinics.clinic.show');
    Route::post('/', [ClinicsController::class, 'store'])
         ->name('api.clinics.clinic.store');
    Route::put('clinic/{clinic}', [ClinicsController::class, 'update'])
         ->name('api.clinics.clinic.update');
    Route::delete('/clinic/{clinic}',[ClinicsController::class, 'destroy'])
         ->name('api.clinics.clinic.destroy');
});

Route::middleware('auth:api')->prefix('/specialties')->group(function(){
    Route::get('/', [SpecialtiesController::class, 'index'])
         ->name('api.specialties.specialtie.index');
    Route::get('/show/{specialtie}',[SpecialtiesController::class, 'show'])
         ->name('api.specialties.specialtie.show');
    Route::post('/', [SpecialtiesController::class, 'store'])
         ->name('api.specialties.specialtie.store');
    Route::put('specialtie/{specialtie}', [SpecialtiesController::class, 'update'])
         ->name('api.specialties.specialtie.update');
    Route::delete('/specialtie/{specialtie}',[SpecialtiesController::class, 'destroy'])
         ->name('api.specialties.specialtie.destroy');
});

Route::middleware('auth:api')->prefix('/doctors')->group(function(){

    Route::get('/', [DoctorsController::class, 'index'])
         ->name('api.doctors.doctor.index');
    Route::get('/show/{doctor}',[DoctorsController::class, 'show'])
         ->name('api.doctors.doctor.show');
    Route::post('/', [DoctorsController::class, 'store'])
         ->name('api.doctors.doctor.store');
    Route::put('doctor/{doctor}', [DoctorsController::class, 'update'])
         ->name('api.doctors.doctor.update');
    Route::delete('/doctor/{doctor}',[DoctorsController::class, 'destroy'])
         ->name('api.doctors.doctor.destroy');
});

Route::middleware('auth:api')->prefix('/patients')->group(function(){

    Route::get('/', [PatientsController::class, 'index'])
         ->name('api.patients.patient.index');
    Route::get('/show/{patient}',[PatientsController::class, 'show'])
         ->name('api.patients.patient.show');
    Route::post('/', [PatientsController::class, 'store'])
         ->name('api.patients.patient.store');
    Route::put('patient/{patient}', [PatientsController::class, 'update'])
         ->name('api.patients.patient.update');
    Route::delete('/patient/{patient}',[PatientsController::class, 'destroy'])
         ->name('api.patients.patient.destroy');
});

Route::middleware('auth:api')->prefix('/reservations')->group(function(){
    Route::get('/', [ReservationsController::class, 'index'])
         ->name('api.reservations.reservation.index');
    Route::get('/show/{reservation}',[ReservationsController::class, 'show'])
         ->name('api.reservations.reservation.show');
    Route::post('/', [ReservationsController::class, 'store'])
         ->name('api.reservations.reservation.store');
    Route::put('reservation/{reservation}', [ReservationsController::class, 'update'])
         ->name('api.reservations.reservation.update');
    Route::delete('/reservation/{reservation}',[ReservationsController::class, 'destroy'])
         ->name('api.reservations.reservation.destroy');
});

Route::middleware('auth:api')->prefix('/horaries')->group(function(){

    Route::get('/', [HorariesController::class, 'index'])
         ->name('api.horaries.horary.index');
    Route::get('/show/{horary}',[HorariesController::class, 'show'])
         ->name('api.horaries.horary.show');
    Route::post('/', [HorariesController::class, 'store'])
         ->name('api.horaries.horary.store');
    Route::put('horary/{horary}', [HorariesController::class, 'update'])
         ->name('api.horaries.horary.update');
    Route::delete('/horary/{horary}',[HorariesController::class, 'destroy'])
         ->name('api.horaries.horary.destroy');
});

Route::group([
    'prefix' => 'users',
], function () {
    Route::post('/change/rol', [UsersController::class, 'changeId']);
    Route::get('/', [UsersController::class, 'index'])
         ->name('api.users.user.index');
    Route::get('/show/{user}',[UsersController::class, 'show'])
         ->name('api.users.user.show');
    Route::post('/', [UsersController::class, 'store'])
         ->name('api.users.user.store');
    Route::put('user/{user}', [UsersController::class, 'update'])
         ->name('api.users.user.update');
    Route::delete('/user/{user}',[UsersController::class, 'destroy'])
         ->name('api.users.user.destroy');
});
