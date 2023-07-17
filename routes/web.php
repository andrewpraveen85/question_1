<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
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
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('login-confirm', [CustomAuthController::class, 'loginConfirm'])->name('login.confirm'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard'); 

Route::get('order-insert', [CustomAuthController::class, 'orderInsert'])->name('order.insert');
Route::post('order-insert-confirm', [CustomAuthController::class, 'orderInsertConfirm'])->name('order.insert.confirm');
Route::get('order-select/{id}', [CustomAuthController::class, 'orderSelect'])->name('order.select');
Route::post('order-item-insert', [CustomAuthController::class, 'orderItemInsert'])->name('order.item.insert');
Route::post('order-item-delete', [CustomAuthController::class, 'orderItemDelete'])->name('order.item.delete');
Route::get('order-update/{id}', [CustomAuthController::class, 'orderUpdate'])->name('order.update');
Route::post('order-update-confirm', [CustomAuthController::class, 'orderUpdateConfirm'])->name('order.update.confirm');

Route::get('report-today/{date}', [CustomAuthController::class, 'reportToday'])->name('report.today');
Route::post('report-date', [CustomAuthController::class, 'reportDate'])->name('report.date');
Route::get('report-famous', [CustomAuthController::class, 'reportFamous'])->name('report.famous');
