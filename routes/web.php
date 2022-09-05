<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadCon;
use App\Http\Controllers\MessagesCon;
use App\Http\Controllers\CategoriesCon;
use App\Http\Controllers\UsersCon;

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

Route::get('/', [CategoriesCon::class, 'index'])->name('indexCategory');
Route::get('/threads', [ThreadCon::class, 'index'])->name('indexThread');
Route::post('/new_thread/store', [ThreadCon::class, 'store'])->name('storeThread');
Route::get('/new_thread', [ThreadCon::class, 'create'])->name('createThread');
Route::post('/new_message/store', [MessagesCon::class, 'store'])->name('storeMessage');
Route::get('/new_message/answer/{question}', [MessagesCon::class, 'createAnswer'])->name('createAnswerMsg');
Route::get('/thread/{thread}', [MessagesCon::class, 'messagesByThread'])->name('threadView');
Route::get('/message/{thread}', [MessagesCon::class, 'create'])->name('createMessage');
Route::get('/threads/{category}', [ThreadCon::class, 'threadsByCategory'])->name('threadCategory');
Route::post('close_thread/{thread}', [ThreadCon::class, 'close'])->name('closeThread');
Route::post('update_thread/{thread}', [ThreadCon::class, 'save'])->name('updateThread');
Route::get('update_message/{message}/edit', [MessagesCon::class, 'edit'])->name('editMessage');
Route::post('update_message/{message}', [MessagesCon::class, 'update'])->name('updateMessage');
Route::get('user/{user}', [UsersCon::class, 'show'])->name('userShow');
Route::post('update_category/{category}', [CategoriesCon::class, 'update'])->name('updateCategory');
Route::post('delete_category/{category}', [CategoriesCon::class, 'destroy'])->name('deleteCategory');
Route::post('delete_thread/{thread}', [ThreadCon::class, 'destroy'])->name('deleteThread');
Route::post('delete_message/{message}', [MessagesCon::class, 'destroy'])->name('deleteMessage');
Route::post('new_category/', [CategoriesCon::class, 'create'])->name('createCategory');
Route::post('new_role/{user}', [UsersCon::class, 'changeRole'])->name('changeRole');

require __DIR__.'/auth.php';
