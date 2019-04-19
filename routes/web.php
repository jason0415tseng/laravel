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



//把model寫在檔案最上面，使用use來載入User的model
//在function中就只要寫User就可以了，是不是方便很多
// use App\User

// Route::get('api/users/{user}', function (User $user) {
//     return $user;
// });

Route::get('api/users/{user}', function (App\User $user) {
    return $user->email;
});


// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // 使用 first 和 second 中間件
//     });

//     Route::get('user/profile', function () {
//         // 使用 first 和 second 中間件
//     });
// });



//1號路由
Route::get('/users/{id?}',function($id=null){
    if(!is_null($id)){
        //如果有id就重導向至/student/profile
        return redirect()->route('profile');
    }else{
        return '無使用者資料';
    }
});


//2號路由
Route::get('/student/profile',function(){
    return '已查到使用者資料';
})->name('profile');


// Route::get('/news','NewsController@index');

//一次建好CRUD的路由 resource
//查詢目前有哪些路由 指令: php artisan route:list
// Route::resource('news','Newscontroller');


// Route::get('user/{id}', 'ShowProfile');


Route::get('/','NewsController@hello');


Route::get('/news/{id}','NewsController@show_id');


Route::get('profile', 'UserController@show')->middleware('auth');

//新增
Route::get('/insert',function(){
    DB::insert('insert into news(title,description) values(?, ?)',['最新消息','這是一則勁爆的消息']);
});


//新增一筆資料
Route::get('/inserdata',function(){
    $post = new News;
    $post->title = 'goodjob';
    $post->description = '這是一則描述';
    $post->save();
});

//create新增,model裡面新增允許的欄位
Route::get('/create', function(){
    News::create(['title'=>'利用create新增的','description'=>'create的描述']);
});

//讀取
Route::get('/read', function(){
    // $results = DB::select('select * from news where id = ?',[1]);
    // // return $results;
    // foreach($results as $new){
    //     return $new->title;
    // }
    $posts = News::all();
    // return $posts;
    
    foreach($posts as $post){
        // print_r($post);
        return $post->title;
    };
});

//讀取特定資料
Route::get('/find',function(){
    $post = News::find(1);
    return $post;
});

//搜尋
Route::get('/findwhere', function(){
    //Where : 收尋特定欄位的資料 id = 1 、 take : 限定取得幾筆資料
    // $post = News::where('id',1)->orderBy('title','desc')->take(1)->get();
    //where 判斷修改
    $post = News::where('id','>',0)->orderBy('title','desc')->get();
    // print_r(json_decode($post));
    $post = json_decode($post);
    print_r($post);
    return $post;
});


//更新
Route::get('/update',function(){
    $updated = DB::update('update news set title = "更新最新消息" where id = ?',[1]);
    return $updated;
});

//刪除
Route::get('/delete',function(){
    $deleted = DB::delete('delete from news where id = ?',[1]);
    return $deleted;
});



Auth::routes();

//登入介面
Route::get('login' , 'backend\LoginController@index')->name('login');

//登入
Route::post('/login', 'backend\LoginController@login');


//註冊介面
Route::get('register' , 'frontend\RegisterController@index')->name('register');
// Route::get('store', 'Frontend\StoreController@index')->name('store');
    // return '註冊';

//註冊
Route::post('/register', 'frontend\RegisterController@create');

