<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('gender', [\App\Http\Controllers\Api\V1\Gender\GenderController::class, 'index']);