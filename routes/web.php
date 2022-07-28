<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Datatable\OrderDatatable;

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
    return view('welcome2');
})->middleware(['auth']);
Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
    Route::get('create', [PermissionController::class, 'create'])->name('create');
    Route::post('store', [PermissionController::class, 'store'])->name('store');
    Route::get('index', [PermissionController::class, 'index'])->name('index');
    Route::get('editpermission/{id}', [PermissionController::class, 'edit'])->name('editpermission');
    Route::post('deletepermission', [PermissionController::class, 'delete'])->name('deletepermission');
    Route::post('updatepermission', [PermissionController::class, 'update'])->name('updatepermission');
});
Route::group(['prefix' => 'roles'], function () {
    Route::get('createrole', [RoleController::class, 'create'])->name('rolecreate');
    Route::post('storerole', [RoleController::class, 'store'])->name('storerole');
    Route::get('allroles', [RoleController::class, 'index'])->name('allroles');
    Route::get('editrole/{id}', [RoleController::class, 'edit'])->name('editrole');
    Route::post('deleterole', [RoleController::class, 'delete'])->name('deleterole');
    Route::post('updaterole', [RoleController::class, 'update'])->name('updaterole');
});
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('show/{id}', [UserController::class, 'show'])->name('show');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('update');
    Route::post('delete', [UserController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'order', 'as' => 'orders.'], function () {
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::get('edit/{id}', [OrderController::class, 'edit'])->name('edit');
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/datatable', [OrderDatatable::class, 'index'])->name('indexd');
    Route::post('delete', [OrderController::class, 'delete'])->name('delete');
    Route::post('store', [OrderController::class, 'store'])->name('store');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
