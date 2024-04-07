<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LookUp\LookUpController;

Route::group([], function () { //'namespace' => 'LookUp', 'as' => 'lookups.'
    // Route::get('/{lookup}', 'LookUpController@getLookup')->name('lookup');
    Route::get('/{lookup}', [LookUpController::class, 'getLookup'])->name('lookup');
});
