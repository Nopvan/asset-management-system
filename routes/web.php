<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemLoanController;
use App\Http\Controllers\RoomLoanController;
use App\Models\Room;
use App\Models\RoomLoan;

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/customerservice', function () {
        return view('customer_service');
    });

    // Auth
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('/rooms-borrow', [AssetController::class, 'indexBorrowRoom'])->name('rooms.indexborrow');


    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

        Route::get('/item/export-pdf', [ItemController::class, 'exportPdf'])->name('items.export.pdf');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    });
    
    // Khusus user
    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/assets/{item}/pinjam', [AssetController::class, 'showPinjamForm'])->name('assets.form_pinjam.form');
        Route::post('/assets/{item}/pinjam', [ItemLoanController::class, 'store'])->name('assets.form_pinjam');
        Route::post('/assets/borrow/{id}/return', [AssetController::class, 'requestReturn'])->name('assets.borrow.return');
        Route::post('/assets/borrow/{id}/confirm', [AssetController::class, 'confirmReturn'])->name('assets.borrow.confirm');
        Route::get('/assets/borrow', [AssetController::class, 'myBorrows'])->middleware('auth')->name('assets.borrow.index');
        Route::get('/rooms/borrow', [AssetController::class, 'myBorrowsRoom'])->middleware('auth')->name('rooms.borrow.index');
        Route::get('/rooms/borrow/{id}', [AssetController::class, 'showBorrowRoom'])->middleware('auth')->name('rooms.borrow.show');

        Route::get('/rooms/{id}/pinjam', [AssetController::class, 'showPinjamFormRoom'])->name('rooms.form_pinjam.form');
        Route::post('/rooms/{room}/pinjam', [RoomLoanController::class, 'store'])->name('rooms.form_pinjam');
        Route::patch('/borrow-room/request-return/{id}', [RoomLoanController::class, 'requestReturn'])->name('room_loans.request_return');
    });

    Route::middleware(['auth', 'role:super_admin'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Khusus super_admin & resepsionis
    Route::middleware(['auth', 'role:super_admin,resepsionis'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Routes Item
        Route::get('/item', [ItemController::class, 'index']);
        Route::get('/items/lost', [ItemController::class, 'lostItems'])->name('items.lost');
        Route::get('/items/broken', [ItemController::class, 'brokenItems'])->name('items.broken');
        Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
        Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/item', [ItemController::class, 'store'])->name('item.store');
        Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.show');
        Route::put('/item/{id}', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/item/{id}', [ItemController::class, 'destroy'])->name('item.destroy');


        // Routes Category
        Route::get('/category', [CategoryController::class, 'index']);
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

        // Routes Location
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/locations/{id}', [LocationController::class, 'show'])->name('locations.show');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/locations/edit/{id}', [LocationController::class, 'edit'])->name('locations.edit');
        Route::get('/locations/export/pdf', [LocationController::class, 'exportPdf'])->name('locations.export.pdf');

        Route::get('/locations/{id}/rooms', [RoomController::class, 'byLocation'])->name('rooms.byLocation');
        Route::get('/rooms/{id}/items', [ItemController::class, 'byRoom'])->name('items.byRoom');

        // Routes Room
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/edit/{id}', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
        Route::get('/rooms/export/pdf', [RoomController::class, 'exportPdf'])->name('rooms.export.pdf');
        Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
        


        Route::get('/category/export-pdf', [CategoryController::class, 'exportPdf'])->name('categories.export.pdf');


        // Routes Borrow
        Route::get('/loansitem', [ItemLoanController::class, 'index'])->name('borrow.index');
        Route::get('/loansitem/{id}', [ItemLoanController::class, 'show'])->name('item_loans.show');
        Route::patch('/loansitem/{id}/accept', [ItemLoanController::class, 'accept'])->name('item_loans.accept');
        Route::patch('/loansitem/return/{id}', [ItemLoanController::class, 'returnItem'])->name('item_loans.return');
        Route::get('/borrow/export-pdf', [ItemLoanController::class, 'exportPdf'])->name('borrow.export.pdf');
        Route::patch('/borrow/{id}/confirm', [AssetController::class, 'confirmReturn'])->name('borrow.confirm');
        Route::patch('/borrow/{id}/reject', [AssetController::class, 'rejectReturn'])->name('borrow.reject');

        Route::get('/borrow-room', [RoomLoanController::class, 'index'])->name('borrow.room.index');
        Route::get('/borrow-room/{id}', [RoomLoanController::class, 'show'])->name('room-loans.show');
        Route::get('/borrow-room/export-pdf', [RoomLoanController::class, 'exportPdf'])->name('borrow.room.export.pdf');
        Route::patch('/borrow-room/{roomLoan}/accept', [RoomLoanController::class, 'accept'])->name('room_loans.accept');
        Route::patch('/room_loans/return/{id}', [RoomLoanController::class, 'returnRoom'])->name('room_loans.return');


    });