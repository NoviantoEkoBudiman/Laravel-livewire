<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;

Route::get('/', function () {
    return view('welcome');
});
Route::Get("login",Login::class);