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

// Route::get('/', function () {
//     return view('index');
// });

if (! App::environment('local')) {
    URL::forceScheme('https');
}

// トップページ
Route::get('/', function () {
    return view('index');
});

// 申し込みページ
Route::get('/contact', function () {
    return view('contact');
});

// 申し込み完了ページ
Route::get('/thanks', function() {
    return view('thanks');
});

// サービス紹介ページ
Route::get('/service', function() {
    return view('service');
});

// 特定商取引法に基づく表記
Route::get('/asct', function() {
    return view('asct');
});


// // 申し込みページ
// Route::get('/entry', 'EntryController@create');
// Route::post('/confirm', 'EntryController@confirm');
// Route::post('/complete', 'EntryController@store');


// // お問い合わせページ WIP
// Route::get('/contact', 'ContactController@create');
// Route::post('/contact', 'ContactController@store');
