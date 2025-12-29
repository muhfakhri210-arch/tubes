<?php
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;

// READ - Tampilkan semua ulasan
Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');

// CREATE - Simpan ulasan baru
Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

// UPDATE - Update ulasan
Route::put('/ulasan/{id}', [UlasanController::class, 'update'])->name('ulasan.update');

// DELETE - Hapus ulasan  
Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');