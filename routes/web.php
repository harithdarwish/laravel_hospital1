<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;

use App\Http\Controllers\Admin\AdminController;


Route::get('/',[HomeController::class,'index']);


#Route::get('/home',[HomeController::class,'redirect']);
Route::get('/home',[HomeController::class,'redirect']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/add_doctor_view',[AdminController::class,'addview']);

Route::post('/upload_doctor',[AdminController::class,'upload']);

#appointment 1. create the fx in HomeController 2. Use the appointment model while create the fx in HomeController
Route::post('/appointment',[HomeController::class,'appointment']);

#myappointment use GET for user to view 1. create the fx in HomeController 2. Use the appointment model while create the fx in HomeController
Route::get('/myappointment',[HomeController::class,'myappointment']);

#cancelappointment use GET for user to view 1. create the fx in HomeController 2. Use the appointment model while create the fx in HomeController
Route::get('/cancel_appoint/{id}',[HomeController::class,'cancel_appoint']);

#showappointment use GET for admin to view 1. create the fx in HomeController 2. Use the appointment model while create the fx in HomeController
Route::get('/showappointment',[AdminController::class,'showappointment']);

#approved use GET for admin to approved 1. create the button approved in admin.showappointment 2. create fx 
Route::get('/approved/{id}',[AdminController::class,'approved']);

Route::get('/canceled/{id}',[AdminController::class,'canceled']);

#showdoctor use GET for admin to view 1. create the fx in AdminController 2. Use the appointment model while create the fx in HomeController
Route::get('/showdoctor',[AdminController::class,'showdoctor']);

#deletedoctor use GET for admin to delete the specific id  1. create the button delete in admin.alldoctor 2. create fx  
Route::get('/deletedoctor/{id}',[AdminController::class,'deletedoctor']);

#deletedoctor use GET for admin to update the specific id  1. create the button update in admin.alldoctor 2. create fx  
Route::get('/updatedoctor/{id}',[AdminController::class,'updatedoctor']);

Route::post('/editdoctor/{id}',[AdminController::class,'editdoctor']);

#send mail
Route::get('/emailview/{id}',[AdminController::class,'emailview']);

Route::post('/sendemail/{id}',[AdminController::class,'sendemail']);
