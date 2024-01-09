<?php

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
    return redirect('login');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' => [
    'auth:sanctum',
    //'verified',
    //'accessrole',
]], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/staff', function () {
        return view('admin.staff');
    })->name('staff');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');

    Route::get('/schools', function () {
        return view('admin.schools');
    })->name('schools');

    Route::get('/agencies', function () {
        return view('admin.agencies');
    })->name('agencies');

    Route::get('/ministries', function () {
        return view('admin.ministries');
    })->name('ministries');

    Route::get('/lgas', function () {
        return view('admin.lgas');
    })->name('lgas');

    Route::get('/salaries', function () {
        return view('admin.salaries');
    })->name('salaries');

    Route::get('/navigation-menus', function () {
        return view('admin.navigation-menus');
    })->name('navigation-menus');

    Route::get('/user-permissions', function () {
        return view('admin.user-permissions');
    })->name('user-permissions');

});