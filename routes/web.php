<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Event;
use App\Http\Controllers\EventOrganizer;
use App\Http\Controllers\EventType;
use App\Http\Controllers\Payment;
use App\Http\Controllers\Ticket;
use App\Http\Controllers\TicketReadem;

use App\Http\Controllers\Authentication;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::controller(Authentication::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/customer/resgister', 'customerRegister');
        Route::post('/event-organizer/register', 'eventOrganizerRegister');
        Route::get('/logout', 'logout');
    });
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });
    Route::resource('customer', Customer::class);
    Route::prefix('customer')->group(function () {
        Route::get('{customer}/active',[Customer::class, 'active']);
        Route::get('{customer}/deactive',[Customer::class, 'deactive']);
    });
    Route::resource('event-organizer', EventOrganizer::class);
    Route::prefix('event-organizer')->group(function () {
        Route::get('{event_organizer}/active',[EventOrganizer::class, 'active']);
        Route::get('{event_organizer}/deactive',[EventOrganizer::class, 'deactive']);
    });
    Route::resource('payment', Payment::class);
    Route::prefix('payment')->group(function () {
        Route::get('{payment}/pending',[Payment::class, 'pending']);
        Route::get('pay/{id}',[Payment::class, 'pay']);
    });

    Route::resource('event-type', EventType::class);
    Route::resource('event', Event::class);
    Route::resource('ticket', Ticket::class);
    Route::resource('readem', TicketReadem::class);
});