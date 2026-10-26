<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController; 
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { 
    // return view('welcome'); 
    return redirect()->route('beranda'); 
}); 
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

Route::get('/produk/all', [ProdukController::class, 'produkAll'])->name('produk.all');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'produkKategori'])->name('produk.kategori');
Route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

// Route autentikasi customer via Google
Route::get('/auth/redirect', [CustomerController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [CustomerController::class, 'callback'])->name('auth.callback');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda')->middleware('auth'); 
 
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login'); 
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login'); 
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout'); 

// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])
    ->name('backend.laporan.formuser')
    ->middleware('auth');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])
    ->name('backend.laporan.cetakuser')
    ->middleware('auth');

Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])->middleware('auth');

Route::resource('backend/customer', CustomerController::class, ['as' => 'backend'])->middleware('auth');

Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth');
Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])
    ->name('backend.foto_produk.store')
    ->middleware('auth');
    Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])
    ->name('backend.foto_produk.destroy')
    ->middleware('auth');
Route::get('produk/{id}', [ProdukController::class, 'show'])->name('backend.produk.show')->middleware('auth');
Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])
    ->name('backend.laporan.formproduk')
    ->middleware('auth');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])
    ->name('backend.laporan.cetakproduk')
    ->middleware('auth');
// group route untuk customer
Route::middleware('is.customer')->group(function () {
    // route untuk halaman akun customer
    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun'])
        ->name('customer.akun');
    // route untuk update akun customer
    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun'])
        ->name('customer.updateakun');
});