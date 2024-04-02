<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/tiket/cek', function () {
    return view('form.check');
})->name('tiket.check');


Route::get('keluar', [AuthController::class, 'keluar'])->name('keluar');
Route::post('login', [AuthController::class, 'postLogin'])->name('post.login');

// Route::get('form/daftar', [FormController::class, 'create'])->name('form.create');
Route::post('form/daftar', [FormController::class, 'store'])->name('form.store');

Route::get('tujuan/select/{id}', [FormController::class, 'selectDest']);
Route::get('uker/select/{id}', [FormController::class, 'selectUker']);

Route::get('form/konfirmasi/{id}', [FormController::class, 'confirm'])->name('form.confirm');
Route::get('tiket/cetak/{rand}/{id}', [FormController::class, 'ticket'])->name('tiket');
Route::post('form/konfirmasi/cek', [FormController::class, 'check'])->name('form.confirm.check');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('bus', [BusController::class, 'index'])->name('bus');
    Route::get('bus/cetak/kursi/{id}', [BusController::class, 'pdfSeat'])->name('bus.pdfSeat');
    Route::get('bus/cetak/kk/{id}', [BusController::class, 'pdfKk'])->name('bus.pdfKk');
    Route::get('dashboard/waktu', [DashboardController::class, 'time'])->name('dashboard.time');

    Route::get('peserta', [BookingController::class, 'index'])->name('peserta');
    Route::get('peserta/cari', [BookingController::class, 'filter'])->name('peserta.filter');

    Route::get('bus/{id}', [BusController::class, 'detail'])->name('bus.detail');
    Route::get('bus/export/{id}', [BusController::class, 'export'])->name('bus.export');

    // select
    Route::get('tiket/{id}', [BookingController::class, 'emailTicket'])->name('tiket.email');
    Route::get('book/validation/{id}', [BookingController::class, 'validation'])->name('book.validation');
    Route::get('book/pdf/{id}', [BookingController::class, 'pdf'])->name('book.pdf');
    Route::get('book/edit/{id}', [BookingController::class, 'edit'])->name('book.edit');
    Route::get('file/delete/{file}/{id}', [BookingController::class, 'deleteFile'])->name('file.delete');
    Route::get('book/validation/true/{id}', [BookingController::class, 'storeValidation'])->name('book.true');
    Route::post('book/validation/false/{id}', [BookingController::class, 'storeValidation'])->name('book.false');
    Route::post('file/update/{id}', [BookingController::class, 'updateFile'])->name('file.update');
    Route::post('book/update/{id}', [BookingController::class, 'update'])->name('book.update');

    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::get('user/tambah', [UserController::class, 'create'])->name('user.create');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('user/tambah', [UserController::class, 'store'])->name('user.store');
});
