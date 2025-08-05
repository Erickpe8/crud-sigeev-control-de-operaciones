<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRegistrationController;
use App\Models\UserType;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\AcademicProgram;
use App\Models\Institution;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/user-types', fn () => UserType::select('id', 'name')->get());
    Route::get('/document-types', fn () => DocumentType::select('id', 'type')->get());
    Route::get('/genders', fn () => Gender::select('id', 'name')->get());
    Route::get('/academic-programs', fn () => AcademicProgram::select('id', 'name')->get());
    Route::get('/institutions', fn () => Institution::select('id', 'name')->get());
});
