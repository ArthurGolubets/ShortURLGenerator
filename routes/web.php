<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('pages.index');})->name('home');

Route::get('/s/{link}', function ($link){
    $item = \App\Models\ShotURL::getLinkByCode($link);
    if($item) return redirect()->away(str($item->long_url));
    else return redirect()->route('home');
});

