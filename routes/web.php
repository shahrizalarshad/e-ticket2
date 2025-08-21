<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('events.index');
});
Route::resource('events', EventController::class);
Route::resource('tickets', TicketController::class);
