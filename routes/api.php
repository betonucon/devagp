<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\SoController;
use App\Http\Controllers\Api\CroneController;
use App\Http\Controllers\Api\FakturController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('customer/login', [AuthController::class, 'login_customer']);
Route::post('cek-login', [AuthController::class, 'cek_login']);
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'barang','middleware'    => 'auth:sanctum'],function(){
    Route::get('/', [ProdukController::class, 'index']);
});
Route::post('/save_data_api', [MasterController::class, 'save_data_api']);

Route::group(['prefix' => 'crone'],function(){
    Route::get('/barang', [CroneController::class, 'barang']);
});
Route::group(['prefix' => 'master'],function(){
    Route::get('/provinsi', [MasterController::class, 'provinsi']);
    Route::get('/kategori_produk', [MasterController::class, 'kategori_produk']);
    Route::get('/kota/{Kd_Propinsi?}', [MasterController::class, 'kota']);
    Route::get('/kecamatan/{Kd_Kabupaten?}', [MasterController::class, 'kecamatan']);
});
Route::group(['prefix' => 'so','middleware'    => 'auth:sanctum'],function(){
    Route::post('/create', [SoController::class, 'create']);
    Route::get('/keranjang', [SoController::class, 'keranjang']);
    Route::get('/hapus', [SoController::class, 'hapus']);
    Route::get('/hapus_order', [SoController::class, 'hapus_order']);
});
Route::group(['middleware'    => 'auth:sanctum'],function(){
    Route::get('/faktur', [FakturController::class, 'customer_faktur']);
    
    Route::get('/faktur/detail', [FakturController::class, 'faktur']);
});
Route::group(['middleware'    => 'auth:sanctum'],function(){
    Route::get('/tagihan', [SalesController::class, 'tagihan']);
});
Route::group(['middleware'    => 'auth:sanctum'],function(){
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer_first', [CustomerController::class, 'customer_first']);


    Route::get('/media', [SalesController::class, 'media']);
    Route::post('/absen', [SalesController::class, 'absen']);
    Route::get('/jalur_sales', [SalesController::class, 'jalur_sales']);
    Route::get('/jalur_sales_prev', [SalesController::class, 'jalur_sales_prev']);
    Route::get('/jalur_sales_riwayat', [SalesController::class, 'jalur_sales_riwayat']);
    Route::get('/jadwal_sales/{id?}', [SalesController::class, 'jadwal_sales']);
    Route::get('/jadwal_sales_prev', [SalesController::class, 'jadwal_sales_prev']);
    Route::get('/jadwal_sales_riwayat', [SalesController::class, 'jadwal_sales_riwayat']);
});
Route::post('register', [AuthController::class, 'register']);
