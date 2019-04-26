<?php

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

// use App\News as NewsModel;
use App\News;
use App\Http\Middleware\CheckData;



//把model寫在檔案最上面，使用use來載入User的model
//在function中就只要寫User就可以了，是不是方便很多
// use App\User



// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/','NewsController@hello');

Auth::routes();

//登入介面
Route::get('/login' , 'backend\LoginController@index')->middleware('CheckLogin')->name('login');

//登入
Route::post('/login', 'backend\LoginController@login')->middleware('CheckData');

//登入成功
Route::get('/success' , 'backend\LoginController@show')->middleware('CheckSession')->name('success');

//登出
Route::get('/logout', 'backend\LoginController@logout')->name('logout');

//註冊介面
Route::get('/register' , 'frontend\RegisterController@index')->middleware('CheckLogin')->name('register');

//註冊
Route::post('/register', 'frontend\RegisterController@create');

//會員中心
Route::get('/memberCenter', 'MemberCenterController@index')->name('memberCenter');
// MemberCentre

//管理者
Route::get('/admin', 'backend\AdminController@index')->name('admin');

//管理者->取帳號資料
Route::get('/admin/{user}', 'backend\AdminController@getaccount')->name('admin.account');

//管理者->修改帳號資料
Route::post('/admin/{user}', 'backend\AdminController@editaccount');

