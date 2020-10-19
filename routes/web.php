<?php

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

//メインページ
Route::get('/', 'MainPageController@index')->name('main');

Route::post('/conditions', 'MainPageController@conditions')->name('conditions');

Route::post('/freeword', 'MainPageController@freeword')->name('freeword');

Route::post('/locationinfomation', 'MainPageController@locationinfomation');
//ガイダンス
Route::get('/guidance','footerMenuController@guidance')->name('guidance');
//規約
Route::get('/rule','footerMenuController@rule')->name('rule');
//問合せフォーム
Route::get('/inquery','footerMenuController@inquery')->name('inquery');
//問合せ処理
Route::post('/inquery','footerMenuController@inqueryPost');
//検索処理
Route::post('/search','searchController@search');
