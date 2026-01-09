<?php

use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::any('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    App::setlocale($locale);

    return redirect()->back();
})->name('locale');

Route::group(['middleware' => [
    Localization::class,
]], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
