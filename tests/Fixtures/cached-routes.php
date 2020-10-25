<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@load')->name('route-1');
Route::get('/about', 'PageController@load')->name('route-2');
Route::get('/products', 'PageController@load')->name('route-3');
Route::get('/contact-us', 'PageController@load')->name('route-4');
