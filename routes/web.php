<?php

use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\WebController;
use App\Http\Controllers\Back\PermissionController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\CategoryArticleController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\CommentController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FrontArticleController;
use App\Http\Controllers\Front\AuthorController;
use App\Http\Controllers\SearchController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/tentang', [HomeController::class, 'about'])->name('home.about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('home.contact');
Route::resource('artikel', FrontArticleController::class);
Route::post('artikel/tag', [FrontArticleController::class, 'tag'])->name('artikel.tag');
Route::post('artikel/komentar', [FrontArticleController::class, 'komentar'])->name('artikel.komentar');
Route::post('artikel/komentar/reply', [FrontArticleController::class, 'reply'])->name('artikel.reply');
Route::get('/artikel/reload-captcha', [FrontArticleController::class, 'reloadCaptcha'])->name('artikel.reloadCaptcha');
Route::post('artikel/kategori', [FrontArticleController::class, 'kategori'])->name('artikel.kategori');
Route::post('artikel/pencarian', [FrontArticleController::class, 'pencarian_artikel'])->name('artikel.pencarian');
Route::post('artikel/autocomplete', [FrontArticleController::class, 'pencarian_autocomplete'])->name('artikel.pencarian_autocomplete');
Route::get('artikel/author/{user}', [AuthorController::class, 'author'])->name('artikel.author');

// Back
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
    Route::get('articles/preview/{article}', [ArticleController::class, 'preview'])->name('articles.preview');
    Route::post('articles/draf', [ArticleController::class, 'draf'])->name('articles.draf');
    Route::post('articles/delete-all', [ArticleController::class, 'deleteAll'])->name('articles.deleteAll');
    Route::post('article/update/{article}', [ArticleController::class, 'isPublish'])->name('articles.isPublish');
    Route::post('article/selected-content/{article}', [ArticleController::class, 'selectedContent'])->name('articles.selectedContent');
    Route::get('article/search-category', [ArticleController::class, 'selectSearch']);
    Route::post('article/filter-article', [ArticleController::class, 'filterArticle'])->name('articles.filterArticle');

    Route::resource('comments', CommentController::class);
    Route::post('comments/reply', [CommentController::class, 'commentReplies'])->name('comments.reply');
    Route::post('comments/restore/{reply}', [CommentController::class, 'commentRestore'])->name('comments.restore');
    Route::post('comments/delete-permanently/{reply}', [CommentController::class, 'destroy_permanently'])->name('comments.destroy_permanently');
    Route::post('get-data', [CommentController::class, 'getData'])->name('getData');
    Route::post('replies/status/{reply}', [CommentController::class, 'replies'])->name('replies.update');
    Route::post('replies/destroy/{reply}', [CommentController::class, 'destroy_reply'])->name('replies.destroy');
    Route::resource('pages', PageController::class);
    Route::post('page/ads', [PageController::class, 'ads'])->name('page.ads');
    Route::post('page/ads/update/{reply}', [PageController::class, 'ads_update'])->name('page.ads_update');
    Route::get('article/search-live', [PageController::class, 'searchLive'])->name('artikel.searchLive');
    Route::get('article/search-live-trending', [PageController::class, 'searchliveTrending'])->name('artikel.searchliveTrending');
    Route::post('pagination/fetch', [PageController::class, 'fetchAjax'])->name('page.fetchAjax');

    Route::get('/role-has-permissions/{id}', [RoleController::class, 'roleHasPermission']);

    Route::put('/change_password/{id}', [UserController::class, 'changePassword'])->name('change_password');

    Route::get('/setting', [UserController::class, 'setting'])->name('setting');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';
