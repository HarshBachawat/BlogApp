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

Route::get('/', 'HomeController@welcome')->name('/');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{blog_id}/single-blog', 'HomeController@singleBlog')->name('single-blog');
Route::get('/create-blog', 'HomeController@createBlog')->name('create-blog');

Route::put('/add-blog', 'HomeController@addBlog')->name('add-blog');
Route::get('/{blog_id}/delete-blog', 'HomeController@deleteBlog')->name('delete-blog');
Route::get('/{blog_id}/edit-blog', 'HomeController@editBlog')->name('edit-blog');
Route::put('/update-blog', 'HomeController@updateBlog')->name('update-blog');

Route::get('/about-us', 'HomeController@aboutUs')->name('about-us');