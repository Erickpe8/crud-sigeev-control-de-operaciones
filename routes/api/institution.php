<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('institutions', [\App\Http\Controllers\Api\V1\Institution\InstitutionController::class, 'index']);