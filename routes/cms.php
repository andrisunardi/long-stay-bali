<?php

use App\Livewire\CMS\ForgotPassword\ForgotPasswordPage;
use App\Livewire\CMS\Home\HomePage;
use App\Livewire\CMS\Login\LoginPage;
use App\Livewire\CMS\Logout;
use Illuminate\Support\Facades\Route;

Route::any('login', LoginPage::class)->name('login');
// Route::any('forgot-password', ForgotPasswordPage::class)->name('forgot-password');

Route::group(['middleware' => ['auth', 'role:'.config('app.route_cms_roles')]], function () {
    // Route::any('', HomePage::class)->name('index');

    // Route::prefix('contact')->name('contact.')->as('contact.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/contact.php'));

    // Route::prefix('article')->name('article.')->as('article.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/article.php'));

    // Route::prefix('product')->name('product.')->as('product.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/product.php'));

    // Route::prefix('product-category')->name('product-category.')->as('product-category.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/product-category.php'));

    // Route::prefix('gallery')->name('gallery.')->as('gallery.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/gallery.php'));

    // Route::prefix('gallery-category')->name('gallery-category.')->as('gallery-category.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/gallery-category.php'));

    // Route::prefix('slider')->name('slider.')->as('slider.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/slider.php'));

    // Route::prefix('testimony')->name('testimony.')->as('testimony.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/testimony.php'));

    // Route::prefix('affiliate')->name('affiliate.')->as('affiliate.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/affiliate.php'));

    // Route::prefix('team')->name('team.')->as('team.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/team.php'));

    // Route::prefix('history')->name('history.')->as('history.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/history.php'));

    // Route::prefix('career')->name('career.')->as('career.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/career.php'));

    // Route::prefix('career-benefit')->name('career-benefit.')->as('career-benefit.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/career-benefit.php'));

    // Route::prefix('faq')->name('faq.')->as('faq.')
    //     ->middleware(['role:Super User|Admin'])
    //     ->group(base_path('routes/cms/faq.php'));

    // Route::prefix('configuration')->name('configuration.')->as('configuration.')
    //     ->middleware(['role:Super User|Configuration'])
    //     ->group(base_path('routes/cms/configuration.php'));

    // Route::prefix('profile')->name('profile.')->as('profile.')
    //     ->group(base_path('routes/cms/profile.php'));

    // Route::any('logout', Logout::class)->name('logout');
});
