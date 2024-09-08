<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

// Route::get('/', function () {
//     return view('home');
// })->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';

//products routes
Route::get('/', [ProductsController::class, 'index'])->name('index');
Route::get('/products', [ProductsController::class, 'products'])->name('products')->middleware('auth:admin');
Route::get('/create-product', [ProductsController::class, 'create'])->name('products.create')->middleware('auth:admin');
Route::get('product/{slug}', [ProductsController::class, 'show'])->name('products.show');
Route::post('/create-product', [ProductsController::class, 'store'])->name('products.store')->middleware('auth:admin');
Route::get('product/edit/{slug}', [ProductsController::class, 'edit'])->name('products.edit')->middleware('auth:admin');
Route::put('product/edit/{slug}', [ProductsController::class, 'update'])->name('products.update')->middleware('auth:admin');
Route::delete('product/delete/{slug}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('auth:admin');
Route::get('/trashed_products', [ProductsController::class,'trashed_products'])->name('products.trashed')->middleware('auth:admin');
Route::get('/restore/{slug}', [ProductsController::class,'restore'])->name('products.restore')->middleware('auth:admin');
Route::delete('/force_delete/{slug}', [ProductsController::class,'force_delete'])->name('products.force_delete')->middleware('auth:admin');

//categories route
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories')->middleware('auth:admin');
Route::get('/create-category', [CategoriesController::class, 'create'])->name('categories.create')->middleware('auth:admin');
Route::post('/create-category', [CategoriesController::class, 'store'])->name('categories.store')->middleware('auth:admin');
Route::get('category/edit/{category:slug}', [CategoriesController::class, 'edit'])->name('category.edit')->middleware('auth:admin');
Route::put('category/edit/{category:slug}', [CategoriesController::class, 'update'])->name('category.update')->middleware('auth:admin');
Route::delete('category/delete/{category:slug}', [CategoriesController::class, 'destroy'])->name('category.delete')->middleware('auth:admin');

//sub category route
Route::post('/child_category', [SubCategoryController::class, 'store'])->name('subcategory.store')->middleware('auth:admin');
Route::get('/edit_child_category/{slug}', [SubCategoryController::class, 'edit'])->name('subcategory.edit')->middleware('auth:admin');
Route::put('/update_child_category/{slug}', [SubCategoryController::class, 'update'])->name('subcategory.update')->middleware('auth:admin');
Route::delete('/delete_child_category/{slug}', [SubCategoryController::class, 'destroy'])->name('subcategory.delete')->middleware('auth:admin');
Route::get('/subcategories/{id}', [SubcategoryController::class, 'show'])->name('subcategory.show')->middleware('auth:admin');

//cart routes
Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/checkout/direct/{id}', [CartController::class, 'directCheckout'])->name('checkout.direct')->middleware('auth');
Route::post('/place-order', [CartController::class, 'placeOrder'])->name('placeorder')->middleware('auth');
Route::get('/invoice/{order_number}', [CartController::class, 'invoice'])->name('invoice')->middleware('auth');
Route::get('/invoicepdf/{order_number}', [CartController::class, 'generateInvoice'])->name('invoice.generate');



