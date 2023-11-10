<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
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

require __DIR__.'/auth.php';

Route::get('/', function () {
    return Redirect::to(route('main'));
});

Route::prefix('admin')->group(function () {
    Voyager::routes();
});

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

// Hotels
Route::middleware('auth')->group(function () {
    Route::get('/hotels/all', [HotelController::class, 'showAll'])->name('hotels.get.all');
    Route::get('/hotels/{id}', [HotelController::class, 'showHotel'])->name('hotels.get.accurate');
});

// Booking
Route::middleware('auth')->group(function () {
    Route::get('/bookings', function () {
        return Inertia::render('');
    })->name('bookings');
});

