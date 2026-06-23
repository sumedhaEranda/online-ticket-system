<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AgentTicketController;

Route::get('/', [TicketController::class,'create'])->name('ticket.create');

Route::post(
    '/ticket/store',
    [TicketController::class,'store']
)->name('ticket.store');

Route::get(
    '/ticket/status',
    [TicketController::class,'statusForm']
);

Route::post(
    '/ticket/check',
    [TicketController::class,'checkStatus']
)->name('ticket.check');

Route::get('/ticket/status', [\App\Http\Controllers\TicketController::class, 'status'])->name('ticket.status');

// Keep tokened public URL first
Route::get('/ticket/{reference}/{token}', [TicketController::class, 'publicView'])->name('ticket.public');

// Fallback: allow public lookup by reference only
Route::get('/ticket/{reference}', [TicketController::class, 'publicByReference'])->name('ticket.public.ref');

Auth::routes();

Route::middleware('auth')->group(function(){

    Route::get(
        '/agent/tickets',
        [AgentTicketController::class,'index']
    );

    Route::get(
        '/agent/ticket/{id}',
        [AgentTicketController::class,'show']
    );

    Route::post(
        '/agent/ticket/{id}/reply',
        [AgentTicketController::class,'reply']
    );
});
Auth::routes();

Route::post('/agent/ticket/{id}/close', [AgentTicketController::class, 'close'])
    ->name('agent.ticket.close')
    ->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
