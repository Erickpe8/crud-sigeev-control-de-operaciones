<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('academic-program/{institution}', [\App\Http\Controllers\Api\V1\AcademicProgram\AcademicProgramController::class, 'index']);