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

//首頁
Route::get('/', 'HelloController@index');

//登入介面
Route::get('/login', 'frontend\LoginController@showLoginForm')->middleware('CheckLogin')->name('login');

//登入
Route::post('/login', 'frontend\LoginController@login')->middleware('CheckData');

//登入成功
Route::get('/success', 'frontend\LoginController@showSuccessPage')->middleware('CheckSession')->name('success');

//登出
Route::get('/logout', 'frontend\LoginController@logout')->name('logout');

//忘記密碼介面
Route::get('/password/forgot', 'frontend\ForgotPasswordController@showForgotForm')->name('password.forgot');

//忘記密碼
Route::post('/password/account', 'frontend\ForgotPasswordController@getResetAccount')->name('password.account');

//重設密碼介面
Route::get('/password/reset', 'frontend\ForgotPasswordController@showResetForm')->name('password.reset');

//重設密碼
Route::post('/password/update', 'frontend\ForgotPasswordController@updateAccountPassword')->name('password.update');

//註冊介面
Route::get('/register', 'frontend\RegisterController@showRegisterForm')->middleware('CheckLogin')->name('register');

//註冊
Route::post('/register', 'frontend\RegisterController@createUser');

//會員中心
Route::get('/membercenter', 'frontend\MemberCenterController@index')->name('membercenter');

//訂購資訊
Route::get('/orderinfo', 'frontend\MemberCenterController@getOrderInfo')->name('orderinfo');

//會員修改
Route::post('/membercenter/update', 'frontend\MemberCenterController@updateUser')->name('membercenter.user');

//電影介紹
Route::get('/movie', 'frontend\MovieController@getMovieIndex')->name('movie');

//電影介紹->電影詳細內容
Route::get('/movie/detail/{id}', 'frontend\MovieController@getMovieDetail')->name('movielist.detail');

//電影介紹->電影訂票介面
Route::get('/movie/order/{id}', 'frontend\MovieController@getMovieOrderPage')->middleware('CheckLogin')->name('movie.order');

//電影介紹->電影選位介面
Route::post('/movie/order/selectseat/{id}', 'frontend\MovieController@MovieOrderSelectSeat')->middleware('CheckLogin')->name('movie.orderselectseat');

//電影介紹->電影訂票
Route::post('/movie/order/{id}', 'frontend\MovieController@createOrder')->middleware('CheckLogin')->name('movie.createorder');

//電影時刻查詢
Route::get('/movietime', 'frontend\MovieTimeController@index')->name('movietime');

//活動
Route::get('/activity', 'frontend\ActivityController@showActivityList')->name('activity');

//活動新增介面
Route::get('/activity/add', 'frontend\ActivityController@showActivityAdd');

//活動新增
Route::post('/activity/add', 'frontend\ActivityController@createActivityAdd')->middleware('CheckLogin')->name('activity.create');

//活動修改介面
Route::get('/activity/update/{id}', 'frontend\ActivityController@showActivity');

//活動修改
Route::post('/activity/update/{id}', 'frontend\ActivityController@updateActivity')->middleware('CheckLogin')->name('activity.update');

//活動刪除
Route::delete('/activity/delete/{id}', 'frontend\ActivityController@destroyActivity')->middleware('CheckLogin')->name('activity.destroy');

//活動->活動詳細內容
Route::get('/activity/detail/{id}', 'frontend\ActivityController@showActivityDetail')->name('activity.detail');

//活動->投票
Route::post('/activity/vote/{id}', 'frontend\ActivityController@createVote')->middleware('CheckLogin')->name('activity.vote');

//活動->投票結果
Route::get('/activity/voteresult/{id}', 'frontend\ActivityController@showVoteResult')->name('activity.voteresult');

//管理者
Route::get('/admin', 'backend\AdminController@showAccountList')->middleware('CheckManager')->name('admin');

//管理者->取帳號資料
Route::get('/admin/{user}', 'backend\AdminController@getAccount')->middleware('CheckManager')->name('admin.account');

//管理者->修改帳號資料
Route::post('/admin/update', 'backend\AdminController@updateAccount')->middleware('CheckManager')->middleware('CheckAdmin');

//管理者->刪除帳號資料
Route::post('/admin/delete', 'backend\AdminController@deleteAccount')->middleware('CheckManager')->name('admin.delete');

//管理者->電影管理介面
Route::get('/moviemanager', 'backend\MovieManagerController@showMovieList')->middleware('CheckManager')->name('moviemanager');

//管理者->新增電影介面
Route::get('/moviemanager/add', 'backend\MovieManagerController@showAddPage')->middleware('CheckManager');

//管理者->新增電影
Route::post('/moviemanager/movieadd', 'backend\MovieManagerController@createMovie')->middleware('CheckManager')->name('moive.movieadd');

//管理者->取電影資料
Route::get('/moviemanager/movieedit/{id}', 'backend\MovieManagerController@getMovie')->middleware('CheckManager')->name('moive.movieedit');

//管理者->修改電影資料
Route::post('/moviemanager/update/{id}', 'backend\MovieManagerController@updateMovie')->middleware('CheckManager')->name('moive.movieupdate');

//管理者->刪除電影資料
Route::get('/moviemanager/delete/{id}', 'backend\MovieManagerController@deleteMovie')->middleware('CheckManager')->name('movie.moviedelete');

//管理者->時刻管理介面
Route::get('/timemanager', 'backend\TimeManagerController@showMovieList')->middleware('CheckManager')->name('timemanager');

//管理者->新增時刻介面
Route::get('/timemanager/timeadd/{id}', 'backend\timeManagerController@showAddPage')->middleware('CheckManager');

//管理者->新增/修改時刻介面
Route::post('/timemanager/timeadd/{id}', 'backend\timeManagerController@updateTime')->middleware('CheckManager')->name('time.timeadd');
