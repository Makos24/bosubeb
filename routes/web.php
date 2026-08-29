<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {

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
