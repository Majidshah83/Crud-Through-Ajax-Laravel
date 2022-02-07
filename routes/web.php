<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxBOOKCRUDController;


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
    return view('welcome');
});

Route::get('ajax-book-crud', [AjaxBOOKCRUDController::class, 'index']);
Route::get('fetch-books', [AjaxBOOKCRUDController::class, 'fetchbook']);
Route::post('update-book/{id}',[AjaxBOOKCRUDController::class, 'update']);
Route::post('add-book',[AjaxBOOKCRUDController::class, 'store']);
Route::get('edit-book/{id}', [AjaxBOOKCRUDController::class, 'edit']);
Route::delete('delete-book/{id}', [AjaxBOOKCRUDController::class, 'destroy']);