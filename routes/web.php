<?php

/**
 * Application routes.
 */
Route::get('/', function () {

    $comics =  \App\Comedian::all();

    return view('layouts.home', [
        'comics' => $comics
    ]);
});


Route::get('/crawl', 'CrawlerController@execute')->name('crawl');
Route::get('/bio', 'CrawlerController@getBio')->name('bio');
