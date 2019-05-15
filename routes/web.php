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


Route::get('/', 'NewsController@hello');

Auth::routes();

//登入介面
Route::get('/login', 'backend\LoginController@index')->middleware('CheckLogin')->name('login');

//登入
Route::post('/login', 'backend\LoginController@login')->middleware('CheckData');

//登入成功
Route::get('/success', 'backend\LoginController@show')->middleware('CheckSession')->name('success');

//登出
Route::get('/logout', 'backend\LoginController@logout')->name('logout');

//忘記密碼介面
Route::get('/password/forgot', 'frontend\ForgotPasswordController@index')->name('password.forgot');

//忘記密碼
Route::post('/password/account', 'frontend\ForgotPasswordController@resetaccount')->name('password.account');

//重設密碼介面
Route::get('/password/reset', 'frontend\ForgotPasswordController@resetindex')->name('password.reset');

//重設密碼
Route::post('/password/update', 'frontend\ForgotPasswordController@reset')->name('password.update');

//註冊介面
Route::get('/register', 'frontend\RegisterController@index')->middleware('CheckLogin')->name('register');

//註冊
Route::post('/register', 'frontend\RegisterController@create');

//會員中心
Route::get('/memberCenter', 'frontend\MemberCenterController@index')->name('memberCenter');

//訂購資訊
Route::get('/orderinfo', 'frontend\MemberCenterController@getorder')->name('orderinfo');

//會員修改
Route::post('/memberCenter/update', 'frontend\MemberCenterController@updateuser')->name('memberCenter.user');

//電影介紹
Route::get('/movielist', 'frontend\MovieListController@index')->name('movielist');

//電影介紹->電影詳細內容
Route::get('/movielist/detail/{id}', 'frontend\MovieListController@detail')->name('movielist.detail');

//電影介紹->電影訂票介面
Route::get('/movielist/order/{id}', 'frontend\MovieListController@order')->middleware('CheckLogin')->name('movielist.order');

//電影介紹->電影選位介面
Route::post('/movielist/orderseat/{id}', 'frontend\MovieListController@orderseat')->middleware('CheckLogin')->name('movielist.orderseat');

//電影介紹->電影訂票
Route::post('/movielist/order/{id}', 'frontend\MovieListController@orderadd')->middleware('CheckLogin')->name('movielist.orderadd');

//電影時刻查詢
Route::get('/movietime', 'frontend\MovieTimeController@index')->name('movietime');

//活動
Route::get('/activity', 'frontend\ActivityController@index')->name('activity');

//活動新增介面
Route::get('/activity/activityadd', 'frontend\ActivityController@add');

//活動新增
Route::post('/activity/activityadd', 'frontend\ActivityController@activityadd')->middleware('CheckLogin')->name('activity.activityadd');

//管理者
Route::get('/admin', 'backend\AdminController@index')->middleware('CheckManager')->name('admin');

//管理者->取帳號資料
Route::get('/admin/{user}', 'backend\AdminController@getaccount')->middleware('CheckManager')->name('admin.account');

//管理者->修改帳號資料
Route::post('/admin/update', 'backend\AdminController@editaccount')->middleware('CheckManager')->middleware('CheckAdmin');

//管理者->刪除帳號資料
Route::post('/admin/delete', 'backend\AdminController@deleteaccount')->middleware('CheckManager')->name('admin.delete');

//管理者->電影管理介面
Route::get('/moviemanager', 'backend\MovieManagerController@index')->middleware('CheckManager')->name('moviemanager');

//管理者->新增電影介面
Route::get('/moviemanager/movieadd', 'backend\MovieManagerController@add')->middleware('CheckManager');

//管理者->新增電影
Route::post('/moviemanager/movieadd', 'backend\MovieManagerController@movieadd')->middleware('CheckManager')->name('moive.movieadd');

//管理者->取電影資料
Route::get('/moviemanager/movieedit/{id}', 'backend\MovieManagerController@getmovie')->middleware('CheckManager')->name('moive.movieedit');

//管理者->修改電影資料
Route::post('/moviemanager/update/{id}', 'backend\MovieManagerController@movieedit')->middleware('CheckManager')->name('moive.movieupdate');

//管理者->刪除電影資料
Route::get('/moviemanager/delete/{id}', 'backend\MovieManagerController@moviedelete')->middleware('CheckManager')->name('movie.moviedelete');

//管理者->時刻管理介面
Route::get('/timemanager', 'backend\TimeManagerController@index')->middleware('CheckManager')->name('timemanager');

//管理者->新增時刻介面
Route::get('/timemanager/timeadd/{id}', 'backend\timeManagerController@add')->middleware('CheckManager');

//管理者->新增時刻介面
Route::post('/timemanager/timeadd/{id}', 'backend\timeManagerController@timeadd')->middleware('CheckManager')->name('time.timeadd');

//管理者->取電影時刻資料
Route::get('/timemanager/timeedit/{id}', 'backend\TimeManagerController@getmovietime')->middleware('CheckManager')->name('time.timeedit');
