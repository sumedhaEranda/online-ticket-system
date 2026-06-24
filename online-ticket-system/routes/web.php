<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AgentTicketController;

Route::get('/', [TicketController::class,'create'])->name('ticket.create');

Route::post(
    '/ticket/store',
    [TicketController::class,'store']
)->name('ticket.store');

// Public alias for guest ticket submissions (same controller method)
Route::post('/ticket/public/store', [TicketController::class, 'store'])->name('ticket.public.store');

// make GET requests to this path redirect to the public create form
Route::get('/ticket/public/store', function () {
    return redirect()->route('ticket.create');
});

Route::get(
    '/ticket/public/create',
    [TicketController::class, 'publicCreate']
)->name('ticket.public.create');

Route::get(
    '/ticket/status',
    [TicketController::class,'statusForm']
);

Route::post(
    '/ticket/check',
    [TicketController::class,'checkStatus']
)->name('ticket.check');

Route::get('/ticket/status', [\App\Http\Controllers\TicketController::class, 'status'])->name('ticket.status');

// tokened public URL
Route::get('/ticket/{reference}/token/{token}', [TicketController::class, 'publicView'])->name('ticket.public');

//  public lookup by reference only
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

 Route::post('/agent/ticket/{id}/Resolved', [AgentTicketController::class, 'Resolved'])
    ->name('agent.ticket.Resolved')
    ->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 
