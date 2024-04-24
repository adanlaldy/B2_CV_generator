<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CVController;

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

Route::view('/', 'home');

Route::middleware(['App\Http\Middleware\CheckingDisconnected'])->group(function () {
    Route::get('/registration', [RegistrationController::class, 'form']);
    Route::post('/registration', [RegistrationController::class, 'handling']);
    Route::get('/login', [LoginController::class, 'form']);
    Route::post('/login', [LoginController::class, 'handling']);
});

Route::middleware(['App\Http\Middleware\CheckingConnected'])->group(function () {
    Route::get('/my-account', [AccountController::class, 'home']);
    Route::post('/my-account', [AccountController::class, 'templates_form']);
    Route::get('/templates', [AccountController::class, 'form']);
    Route::post('/templates', [AccountController::class, 'templates_handling']);
    Route::get('/blue-template', [CVController::class, 'blue_template']);
    Route::get('/red-template', [CVController::class, 'red_template']);
    Route::post('/add-hobby', [CVController::class, 'add_hobby']); 
    Route::delete('/delete-hobby', [CVController::class, 'delete_hobby']); 
    Route::post('/add-academic-experience', [CVController::class, 'add_academic_experience']); 
    Route::delete('/delete-academic-experience', [CVController::class, 'delete_academic_experience']); 
    Route::post('/add-professional-experience', [CVController::class, 'add_professional_experience']); 
    Route::delete('/delete-professional-experience', [CVController::class, 'delete_professional_experience']); 
    Route::post('/generate-cv' , [CVController::class, 'generate_cv']);
    Route::delete('/delete-cv', [AccountController::class, 'delete_cv']); 
    Route::post('/download-cv', [AccountController::class, 'download_cv']);
    Route::get('/logout', [AccountController::class, 'logout']);
    Route::post('/add-cv', [CVController::class, 'add_cv']); 
    Route::put('/update-cv', [AccountController::class, 'update_cv']);
});

/*//TODO: faire la page CV
//TODO: faire des middlewares pour hobbies, academic, professional et input null (maybe utiliser des groupes dans ce fichier)

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CVController;


/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::view('/', 'home');

Route::get('/registration', [RegistrationController::class,'form']);

Route::post('/registration', [RegistrationController::class, 'handling']);

Route::get('/login', [LoginController::class, 'form']);

Route::post('/login', [LoginController::class, 'handling']);

Route::get('/my-account', [AccountController::class, 'home'])->middleware('App\Http\Middleware\CheckingConnected');

Route::post('/my-account', [AccountController::class, 'templates_form']);

Route::get('/templates', [AccountController::class, 'form'])->middleware('App\Http\Middleware\CheckingConnected');

Route::post('/templates', [AccountController::class, 'templates_handling']);

Route::get('/blue-template', [CVController::class, 'blue_template'])->middleware('App\Http\Middleware\CheckingConnected');

Route::get('/red-template', [CVController::class, 'red_template'])->middleware('App\Http\Middleware\CheckingConnected');

Route::post('/add-hobby', [CVController::class, 'add_hobby']); 

Route::post('/delete-hobby', [CVController::class, 'delete_hobby']); 

Route::post('/add-academic-experience', [CVController::class, 'add_academic_experience']); 

Route::post('/delete-academic-experience', [CVController::class, 'delete_academic_experience']); 

Route::post('/add-professional-experience', [CVController::class, 'add_professional_experience']); 

Route::post('/delete-professional-experience', [CVController::class, 'delete_professional_experience']); 

Route::post('/generate-cv' , [CVController::class, 'generate_cv']);

Route::delete('/delete-cv', [AccountController::class, 'delete_cv']); 

Route::post('/download-cv', [AccountController::class, 'download_cv']);

Route::get('/logout', [AccountController::class, 'logout']);

//TODO: faire la page CV
//TODO: faire des middlewares pour hobbies, academic, professional et input null (maybe utiliser des groupes dans ce fichier)*/


