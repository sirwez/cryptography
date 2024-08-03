<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncryptController;

Route::post('/postCardBalance', [EncryptController::class, 'postCardBalance']);
Route::get('/BuyItem', [EncryptController::class, 'BuyItem']);
