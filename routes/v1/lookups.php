<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'LookUp', 'as' => 'lookups.'], function () {
    Route::get('/{lookup}', 'LookupController@getLookup')->name('lookup');
});
