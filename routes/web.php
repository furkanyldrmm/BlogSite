<?php

use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
|Backend Routes
|--------------------------------------------------------------------------
|
*/
Route::get('site-bakimda',function(){
    return view('offline');
});
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function() {

    Route::get('giris', 'Back\AuthController@login')->name('giris');
    Route::post('giris', 'Back\AuthController@loginPost')->name('login.post');

});
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
    Route::get('/yazilar/silinen','Back\Yazicontroller@trashed')->name('trashed.yazilar');
//Postlar
    Route::resource('yazilar','Back\Yazicontroller');
    Route::get('panel','Back\Dashboard@index')->name('panel');
    Route::get('cikis','Back\AuthController@logout')->name('logout');
    Route::get('/switch','Back\Yazicontroller@switch')->name('switch');
    Route::get('/sil/{id}','Back\Yazicontroller@sil')->name('yazilar.sil');
    Route::get('/tamsil/{id}','Back\Yazicontroller@harddelete')->name('yazilar.harddelete');

    Route::get('/recover/{id}','Back\Yazicontroller@recover')->name('yazilar.recover');
//Kategoriler
    Route::get('kategoriler','Back\categorycontroller@index')->name('category.index');
    Route::get('kategoriler/status','Back\categorycontroller@switch')->name('category.switch');
    Route::post('kategoriler/create','Back\categorycontroller@create')->name('category.create');
    Route::post('/kategoriler/update','Back\categorycontroller@update')->name('category.update');
    Route::post('/kategoriler/delete','Back\categorycontroller@delete')->name('category.delete');
    Route::get('/kategori/getData','Back\categorycontroller@getData')->name('category.getdata');

//Pages Root
    Route::get('sayfalar','Back\PageController@index')->name('page.index');
    Route::get('/sayfalar/olustur','Back\PageController@create')->name('page.create');
    Route::get('/sayfalar/guncelle/{id}','Back\PageController@update')->name('page.edit');
    Route::post('/sayfalar/guncelle/{id}','Back\PageController@updatePost')->name('page.edit.post');
    Route::post('/sayfalar/olustur','Back\PageController@post')->name('page.create.post');
    Route::get('/sayfa/switch','Back\PageController@switch')->name('page.switch');
    Route::get('/sayfa/sil/{id}','Back\PageController@delete')->name('page.delete');
    Route::get('/sayfa/siralama','Back\PageController@orders')->name('page.orders');
    Route::get('/ayarlar','Back\ConfigController@index')->name('config.index');
    Route::post('/ayarlar/update','Back\ConfigController@update')->name('config.update');

});

/*
|--------------------------------------------------------------------------
|Front Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/','Front\homepage@index')->name('homepage');
Route::get('/sayfa','Front\Homepage@index');
Route::get('/iletisim','Front\Homepage@contact')->name('contact');
Route::post('/iletisim','Front\Homepage@contactpost')->name('contact.post');
Route::get('/kategori/{slug}','Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}','Front\Homepage@single')->name('single');
Route::get('/{sayfa}','Front\Homepage@page')->name('page');

