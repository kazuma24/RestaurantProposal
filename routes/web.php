<?php

use Illuminate\Support\Facades\Route;
use  Illuminate\Support\Facades\Auth;
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
//お気に入り登録機能
Route::post('/favo','favoController@favo');
//認証1
Auth::routes();
//仮登録URL2
Route::post('register/pre_check', 'Auth\RegisterController@pre_check')->name('register.pre_check');
//本会員登録用URL
Route::get('register/verify/{token}', 'Auth\RegisterController@showForm');
//本会員確認画面
Route::post('register/main_check', 'Auth\RegisterController@mainCheck')->name('register.main.check');
//本登録処理
Route::post('register/main_register', 'Auth\RegisterController@mainRegister')->name('register.main.registered');
//ログアウト
Route::get('/logout','Auth\LoginController@logout')->name('logout');
//お気に入りリスト画面表示
Route::get('/favoshow','favoController@favoshow')->name('favoshow');
//お気に入りリスト削除処理
Route::post('/favoshow','favoController@favodelete');
//
Route::get('/newmemberguide','Auth\RegisterController@newmemberguidepageshow')->name('newmemberguide');
