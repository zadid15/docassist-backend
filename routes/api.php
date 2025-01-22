<?php

use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\MedicalRecord\MedicalRecordController;
use App\Http\Controllers\Patient\PatientController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

// Patient
Route::apiResource('/patient', PatientController::class)->middleware('auth:sanctum');

// Medical Records
Route::apiResource('/medical-record', MedicalRecordController::class)->middleware('auth:sanctum');

// Appointment
Route::apiResource('/appointment', AppointmentController::class)->middleware('auth:sanctum');

// Invoice
Route::apiResource('/invoice', InvoiceController::class)->middleware('auth:sanctum');