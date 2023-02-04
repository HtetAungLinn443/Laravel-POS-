<?php

use App\Http\Controllers\API\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RouteCompiler;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('testing',[RouteController::class,'testing']);
Route::get('category/list',[RouteController::class,'categoryList']);
Route::get('product/list',[RouteController::class,'productList']);
Route::post('create/category',[RouteController::class,'createCategory']);
Route::post('create/contact',[RouteController::class,'createContact']);
Route::post('delete/category',[RouteController::class,'deleteCategory']);
Route::post('category/details',[RouteController::class,'categoryDetails']);
Route::post('category/update',[RouteController::class,'categoryUpdate']);
