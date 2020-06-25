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

Route::get('/', function () {
    return view('frontend');
});

Route::get('hello', function () {
    return 'Hello world!!!';
});

Route::get('db', function() {
if (DB::connection()->getDatabaseName())  {
    dd(DB::connection()->getDatabaseName());
} else {
    return 'Соединения нет';
}});

Route::get('hello-view', function () {
    //    return 'Hello world!!!';
    return view('hello', [
        'name'=>'Alex'
    ]);

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::resources(['divisions' => 'DivisionController']);



//GET	/photos	index	photos.index
//GET	/photos/create	create	photos.create
//POST	/photos	store	photos.store
//GET	/photos/{photo}	show	photos.show
//GET	/photos/{photo}/edit	edit	photos.edit
//PUT/PATCH	/photos/{photo}	update	photos.update
//DELETE	/photos/{photo}	destroy	photos.destroy

Route::get('/swagger', function (Request $request) {
    return view('vendor.l5-swagger.index',['urlToDocs'=>'/api']);
});