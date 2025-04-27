<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function(){
    return view('login');
});

Route::get('/register', function(){
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/assets', function () {
    return view('assets');
});

//Routes Item
Route::get('/item', [ItemController::class, 'index']);
Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
Route::post('/item', [ItemController::class, 'store'])->name('item.store');
Route::put('/item/{id}', [ItemController::class, 'update'])->name('item.update');
Route::delete('/item/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

//Routes Category
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


// Print PDF
// Untuk categories
Route::get('/category/export-pdf', [CategoryController::class, 'exportPdf'])->name('categories.export.pdf');
// Untuk assets
Route::get('/item/export-pdf', [ItemController::class, 'exportPdf'])->name('items.export.pdf');
