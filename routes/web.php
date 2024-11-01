<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AngularController;

Route::any('/{any}', [AngularController::class, 'index'])->where('any', '^(?!api).*$');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});