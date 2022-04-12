<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::group(['namespace' => 'API'], function () {

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->middleware('digits-to-en');
    Route::post('login', [AuthController::class, 'login'])->middleware('digits-to-en');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
    });
});



Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('/post')->name('post.')->group(function () {

        Route::get('/', [PostController::class, 'AdminIndex'])->name('index');
        Route::post('/create', [PostController::class, 'create'])->name('create');
        Route::post('/update', [PostController::class, 'update'])->name('update');
        Route::post('/{post}/toggle_active', [PostController::class, 'toggleActive'])->name('toggle_active');
        Route::post('/{post}/attach_tag', [TagController::class, 'assignTag'])->name('tag.attach');
        Route::post('/{post}/detach_tag', [TagController::class, 'unAssignTag'])->name('tag.detach');

    });
// assignTag
    Route::prefix('/tag')->name('tag.')->group(function () {

        Route::get('/', [TagController::class, 'Index'])->name('index');
        Route::post('/create', [TagController::class, 'create'])->name('create');
        Route::post('/{tag}/delete', [TagController::class, 'delete'])->name('delete');


    });

    Route::prefix('/slider')->name('slider.')->group(function () {

        Route::get('/', [SliderController::class, 'Index'])->name('index');
        Route::post('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/{slider}/delete', [SliderController::class, 'delete'])->name('delete');

    });

    Route::prefix('/category')->name('category.')->group(function () {

        Route::get('/', [CategoryController::class, 'Index'])->name('index');
        Route::post('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/{category}/update', [CategoryController::class, 'update'])->name('update');
        Route::post('/{category}/delete', [CategoryController::class, 'delete'])->name('delete');

    });

//    Route::prefix('/comment')->name('comment.')->group(function () {
//        Route::get('/', [CommentController::class, 'Index'])->name('index');
//
//    });

});

Route::prefix('user')->name('user')->group(function () {

    Route::prefix('/comment')->name('comment.')->group(function () {

        Route::post('/create', [CommentController::class, 'create'])->name('create');
        Route::post('/{comment}/update', [CommentController::class, 'update'])->name('update');
        Route::post('/{comment}/delete', [CommentController::class, 'delete'])->name('delete');

    });

});

Route::prefix('home')->name('home.')->group(function () {

    Route::prefix('/post')->name('post.')->group(function () {
        Route::get('/', [PostController::class, 'Index'])->name('index');
        Route::get('/podcasts', [PostController::class, 'IndexPodcasts'])->name('index_podcasts');
        Route::get('/{post}/show', [PostController::class, 'show'])->name('show');

    });

    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'Index'])->name('index');
        Route::get('/{category}/posts', [CategoryController::class, 'getPostByCategory'])->name('post_by_category');

    });

    Route::prefix('/tag')->name('tag.')->group(function () {
        Route::get('/{tag}/posts', [TagController::class, 'getPostByTag'])->name('post_by_tag');
    });

});





Route::group(['middleware' => ['auth:api']], function () {

});
//});
