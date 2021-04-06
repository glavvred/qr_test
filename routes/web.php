<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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


Route::get('/new', [TicketController::class, 'create'])->middleware('auth');
Route::post('/store', [TicketController::class, 'store'])->middleware('auth');
Route::get('/claim/{ticket_id}', [TicketController::class, 'claimForm'])->middleware('auth');;
Route::post('/claim/confirm', [TicketController::class, 'claimABit'])->middleware('auth');;


Auth::routes(['register' => true]);

Route::get('/home', 'HomeController@index')->name('home');
