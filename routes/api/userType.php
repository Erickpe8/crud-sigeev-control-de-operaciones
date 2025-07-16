<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user-type', [\App\Http\Controllers\Api\V1\UserType\UserTypeController::class, 'index']);