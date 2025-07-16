<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('document-type', [\App\Http\Controllers\Api\V1\DocumentType\DocumentTypeController::class, 'index']);