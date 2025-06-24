<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::get('/polls', [PollController::class, 'apiIndex']);
Route::get('/polls/{id}', [PollController::class, 'apiShow']);
Route::post('/polls', [PollController::class, 'store']);
Route::put('/polls/{id}', [PollController::class, 'update']);
Route::delete('/polls/{id}', [PollController::class, 'destroy']);
Route::post('/polls/{id}/vote', [PollController::class, 'vote']);

