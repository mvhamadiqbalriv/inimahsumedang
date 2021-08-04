<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::resource('dashboard', DashboardController::class);

    Route::view('profile', 'profile')->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);
    Route::resource('web', WebController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    Route::resource('category-articles', CategoryArticleController::class);
    Route::post('category-articles/checkCategory', [CategoryArticleController::class, 'checkCategory'])->name('category_articles.checkCategory');
    Route::resource('articles', ArticleController::class);
    Route::post('articles/draf', [ArticleController::class, 'draf'])->name('articles.draf');
    Route::post('articles/delete-all', [ArticleController::class, 'deleteAll'])->name('articles.deleteAll');
    Route::post('article/update/{article}', [ArticleController::class, 'isPublish'])->name('articles.isPublish');
    Route::get('article/search-category', [ArticleController::class, 'selectSearch']);
    Route::get('article/filter-article', [ArticleController::class, 'filterArticle'])->name('articles.filterArticle');


    Route::get('/role-has-permissions/{id}', [RoleController::class, 'roleHasPermission']);

    Route::put('/change_password/{id}', [UserController::class, 'changePassword'])->name('change_password');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';
