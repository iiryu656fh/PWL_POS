<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::pattern('id', '[0-9]+'); //Artinya ketika ada paremeter {id}. maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('postRegister', [AuthController::class, 'postRegister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    Route::group(['prefix' => 'user'], function () {
        Route::middleware(['authortize:ADM'])->group(function () {
            Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datables
            Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']); // menyimpan data user yang diubah
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data User Ajax
            Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
            Route::get('/import', [UserController::class, 'import']); // ajax form uplaod excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); // ajax export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']); // ajax export pdf
        });
    });

    Route::group(['prefix' => 'level'], function () {
        Route::middleware(['authortize:ADM'])->group(function () {
            Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
            Route::post('/list', [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datables
            Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah level
            Route::post('/', [LevelController::class, 'store']); // menyimpan data level baru
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
            Route::put('/{id}', [LevelController::class, 'update']); // menyimpan data level yang diubah
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data User Ajax
            Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
            Route::get('/import', [LevelController::class, 'import']); // ajax form uplaod excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [LevelController::class, 'export_excel']); // ajax export excel
        });
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::middleware(['authortize:ADM,MNG'])->group(function () {
            Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal kategori
            Route::post('/list', [KategoriController::class, 'list']); // menampilkan data kategori dalam bentuk json untuk datables
            Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah kategori
            Route::post('/', [KategoriController::class, 'store']); // menyimpan data kategori baru
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
            Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan data kategori yang diubah
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data User Ajax
            Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
            Route::get('/import', [KategoriController::class, 'import']); // ajax form uplaod excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); // ajax export excel
        });
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::middleware(['authortize:ADM,MNG,STF'])->group(function () {
            Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
            Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datables
            Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
            Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
            Route::put('/{id}', [BarangController::class, 'update']); // menyimpan data barang yang diubah
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data User Ajax
            Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
            Route::get('/import', [BarangController::class, 'import']); // ajax form uplaod excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']); // ajax export excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // ajax export pdf
        });
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::middleware(['authortize:ADM,MNG'])->group(function () {
            Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal supplier
            Route::post('/list', [SupplierController::class, 'list']); // menampilkan data supplier dalam bentuk json untuk datables
            Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah supplier
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data user baru Ajax
            Route::post('/', [SupplierController::class, 'store']); // menyimpan data supplier baru
            Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail supplier
            Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']); // menampilkan detail user ajax
            Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit supplier
            Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan data supplier yang diubah
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //Menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data User Ajax
            Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
            Route::get('/import', [SupplierController::class, 'import']); // ajax form uplaod excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']); // ajax export excel
        });
    });
});
