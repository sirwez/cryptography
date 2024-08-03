<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/postCard', [\App\Http\Controllers\EncryptController::class, 'postCard']);
