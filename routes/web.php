<?php

use App\Livewire\TodoList;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('todos'));

Route::middleware(['auth'])->group(function () {
    Route::get('/todos', TodoList::class)->name('todos');
});

