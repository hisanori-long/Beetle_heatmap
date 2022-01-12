<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;

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
Route::get('reports/search', '\App\Http\Controllers\ReportsController@search')->name("reports.search");
Route::resource('reports', ReportsController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('reports.index');
})->middleware(['auth'])->name('dashboard');

Route::get('/form', 
	[App\Http\Controllers\UploadImageController::class, "show"]
	)->name("image");

    Route::post('/upload', 
	[App\Http\Controllers\UploadImageController::class, "upload"]
	)->name("image");

require __DIR__.'/auth.php';
