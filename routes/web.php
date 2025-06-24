<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::get('/polls/{id}', [PollController::class, 'showWeb'])->name('polls.show');

