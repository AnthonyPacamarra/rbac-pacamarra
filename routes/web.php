<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::view('/','homepage')->name('home');

    Route::get('/acctg',[UserController::class,'loadAcctgPage'])->middleware('role:admin,bookeeper,auditor,audasst')->name('acctg');
    Route::get('/prod',[UserController::class,'loadAssemblePage'])->middleware('role:admin,assembler')->name('prod');

    Route::get('/admin', [AdminController::class, 'index'])->name('dash')->middleware('role:admin');
    Route::get('/admin/users',[AdminController::class,'manageUsers'])->name('usertool')->middleware('role:admin');
    Route::post('/admin/users/updateRoles', [AdminController::class, 'updateRoles'])->name('updateRoles')->middleware('role:admin');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete')->middleware('role:admin');


    Route::get('/admin/roles', [AdminController::class, 'indexRoles'])->name('roles.index')->middleware('role:admin');
    Route::get('/admin/roles/create', [AdminController::class, 'createRole'])->name('roles.create')->middleware('role:admin');
    Route::post('/admin/roles/store', [AdminController::class, 'storeRole'])->name('roles.store')->middleware('role:admin');
    Route::get('/admin/roles/{role}/edit', [AdminController::class, 'editRole'])->name('roles.edit')->middleware('role:admin');
    Route::put('/admin/roles/{role}/update', [AdminController::class, 'updateRole'])->name('roles.update')->middleware('role:admin');
    Route::delete('/admin/roles/{role}/delete', [AdminController::class, 'deleteRole'])->name('roles.delete')->middleware('role:admin');
    Route::get('/admin/roles/{role}/users', [AdminController::class, 'viewUsersByRole'])->name('roles.viewUsers')->middleware('role:admin');


    Route::get('/acctg/new',[BookController::class,'newLedgerEntry'])->middleware(['role:admin,bookeeper,auditor'])->name('newledger');
    Route::post('/acctg/new',[BookController::class,'saveNewLedgerEntry'])->middleware('role:admin,bookeeper')->name('saveledger');
    Route::get('/acctg/view/all',[BookController::class,'showAllLedgers'])->middleware(['role:admin,bookeeper,auditor,audasst'])->name('ledgers');
    Route::get('/acctg/view/{id}',[BookController::class,'viewLedgerDetails'])->middleware(['role:admin,auditor,audasst'])->name('ledger');
});

