<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;

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

Route::get('/', [HomeController::class, 'index']);

/**
 * Automatically creates routes for all functions in the ReportController
 * index,create,store, show, edit, update, destroy
 * Since we are not using a specific  view to create reports, we don't need a route there.
 * */
Route::resource('reports', ReportController::class)->except([
    'create'
]);
