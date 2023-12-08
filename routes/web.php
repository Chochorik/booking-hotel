<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use TCG\Voyager\Facades\Voyager;

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
    return Redirect::to(route('main'));
});

Route::get('/confirm-booking/{bookingId}/{userId}', [BookingController::class, 'confirmBooking']);

Route::get('/hotels', function () {
    return Inertia::render('Main');
})->middleware(['auth', 'verified'])->name('main');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

require __DIR__.'/auth.php';

// Hotels
Route::middleware('auth')->group(function () {
    Route::get('/hotels/all', [HotelController::class, 'index'])->name('hotels.get.all');
    Route::get('/hotels/{id}', [HotelController::class, 'showHotel'])->name('hotels.get.current');
});

// Rooms
Route::middleware('auth')->group(function () {
    Route::get('/room/{id}', [RoomController::class, 'getRoom'])->name('room.get.current');
});

// Facilities
Route::get('/facilities', [FacilityController::class, 'index'])
    ->middleware('auth')
    ->name('facilities');

// Booking
Route::middleware('auth')->group(function () {
    Route::get('/bookings', function () {
        return Inertia::render('Booking/BookingPage');
    })->name('bookings');
    Route::get('/bookings/info', [BookingController::class, 'index'])->name('bookings.info');
    Route::get('/booking/dates/{room_id}', [BookingController::class, 'getBookedDates'])->name('bookings.dates');
    Route::post('/booking', [BookingController::class, 'createBooking'])->name('booking.store');
});



