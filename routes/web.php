<?php

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/account', 'AccountController@index')->name('account');
Route::get('/account/games', 'AccountController@games')->name('account.games');
Route::get('/account/badges', 'AccountController@badges')->name('account.badges');
Route::get('/account/edit', 'AccountController@edit')->name('account.edit');
Route::post('/account/update', 'AccountController@update')->name('account.update');

Route::get('/gallery', 'GalleryController@index')->name('gallery');
Route::get('/blog', 'BlogController@index')->name('blog');
