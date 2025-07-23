<?php

use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;




Route::post('/registrar', [UserRegistrationController::class, 'store']);
