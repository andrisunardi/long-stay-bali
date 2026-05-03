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

Route::any('currency/{currency}', function ($currency) {
    Session::put('currency', $currency);

    return redirect()->back();
})->name('currency');

Route::group(['middleware' => [Localization::class]], function () {
    Route::livewire('/', 'pages::home')->name('home');

    Route::livewire('/about', 'pages::about')->name('about');
    Route::livewire('/service', 'pages::service')->name('service');

    Route::livewire('/guide', 'pages::guide')->name('guide.index');
    Route::livewire('/guide/{slug}', 'pages::guide.detail')->name('guide.detail');

    Route::livewire('/contact', 'pages::contact')->name('contact');

    Route::livewire('/property', 'pages::property')->name('property.index');
    Route::livewire('/property/{slug}', 'pages::property.detail')->name('property.detail');

    Route::prefix('cms')->name('cms.')->as('cms.')->group(base_path('routes/cms.php'));
});

Route::prefix('leadconnector')
    ->name('leadconnector.')
    ->as('leadconnector.')
    ->group(base_path('routes/leadconnector.php'));

Route::prefix('google')
    ->name('google.')
    ->as('google.')
    ->group(base_path('routes/google.php'));
