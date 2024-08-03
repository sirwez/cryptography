<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncryptController;

Route::post('/postCard', [EncryptController::class, 'postCard']);
Route::get('/getCard', [EncryptController::class, 'getCard']);
