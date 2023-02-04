<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\user\AjaxController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

// login , register
Route::middleware(['admin_auth'])->group(function () {

    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    // deshboard
    Route::get('deshboard', [AuthController::class, 'deshboard'])->name('deshboard');

    // admin
    Route::middleware(['admin_auth'])->group(function () {

        // category
        Route::group(['prefix' => 'category'], function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function () {
            // password
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/passwod', [AdminController::class, 'changePassword'])->name('admin#changePassword');

            // account
            Route::get('details', [AdminController::class, 'details'])->name('admin#details');
            Route::get('edit', [AdminController::class, 'edit'])->name('admin#edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('admin#update');

            // admin list
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');
            Route::get('changeRole/{id}', [AdminController::class, 'changeRole'])->name('admin#changeRole');
            Route::post('change/role/{id}', [AdminController::class, 'change'])->name('admin#change');
            Route::get('role/changes', [AdminController::class, 'adminRoleChange'])->name('admin#roleChange');
        });

        // Products
        Route::prefix('products')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('product#list');
            Route::get('createPage', [ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('product#create');
            Route::get('gelete/{id}', [ProductController::class, 'delete'])->name('product#delete');
            Route::get('editPage/{id}', [ProductController::class, 'editPage'])->name('product#editPage');
            Route::get('updatePage/{id}', [ProductController::class, 'updatePage'])->name('product#updatePage');
            Route::post('update', [ProductController::class, 'update'])->name('product#update');
        });

        // Orders
        Route::prefix('order')->group(function () {
            Route::get('list', [OrderController::class, 'orderList'])->name('admin#orderList');
            Route::get('change/status', [OrderController::class, 'changeStatus'])->name('admin#changeStatus');
            Route::get('ajax/change/status', [OrderController::class, 'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}', [OrderController::class, 'listInfo'])->name('admin#listInfo');
        });

        // User List
        Route::prefix('user')->group(function () {
            Route::get('list', [UserController::class, 'userList'])->name('admin#userList');
            Route::get('change/role', [UserController::class, 'userChangeRole'])->name('admin#userChangeRole');
        });

        Route::prefix('contact')->group(function () {
            Route::get('listPage', [ContactController::class, 'contactListPage'])->name('admin#contactListPage');
            Route::get('contact/info/{id}', [ContactController::class, 'adminContactInfo'])->name('admin#contactInfo');
            Route::get('delete/contact/{id}', [ContactController::class, 'deleteContact'])->name('admin#deleteContact');
        });
    });

    // user
    // home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('homePage', [UserController::class, 'homePage'])->name('user#home');
        Route::get('filter/{id}', [UserController::class, 'filter'])->name('user#filter');
        Route::get('history', [UserController::class, 'history'])->name('user#history');

        Route::prefix('pizza')->group(function () {
            Route::get('detailsPage/{id}', [UserController::class, 'detailsPage'])->name('user#detailsPage');
        });

        Route::prefix('cart')->group(function () {
            Route::get('list', [UserController::class, 'cartList'])->name('user#cartList');
        });

        Route::prefix('password')->group(function () {
            Route::get('change', [UserController::class, 'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('change', [UserController::class, 'changePassword'])->name('user#changePassword');
        });

        Route::prefix('profile')->group(function () {
            Route::get('change', [UserController::class, 'accountChangePage'])->name('user#accountChangePage');
            Route::post('change/{id}', [UserController::class, 'accountChange'])->name('user#accountChange');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('pizzaList', [AjaxController::class, 'pizzaList'])->name('ajax#pizzaList');
            Route::get('addToCard', [AjaxController::class, 'addToCard'])->name('ajax#addToCard');
            Route::get('order', [AjaxController::class, 'order'])->name('ajax#order');
            Route::get('clear/cart', [AjaxController::class, 'clearCart'])->name('ajax#clearCart');
            Route::get('clear/current/product', [AjaxController::class, 'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
            Route::get('increase/viewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
        });

        Route::prefix('contact')->group(function () {
            Route::get('contactPage', [ContactController::class, 'contactPage'])->name('user#contactPage');
            Route::post('contact', [ContactController::class, 'contactInfo'])->name('user#contactInfo');
        });

    });
});