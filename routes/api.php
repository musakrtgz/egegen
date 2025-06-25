<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['bearer'])->apiResource('news', \App\Http\Controllers\NewsController::class);
