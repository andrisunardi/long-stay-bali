<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::cms.standard')
    ->name('index')
    ->middleware('permission:standard');

Route::livewire('/add', 'pages::cms.standard.add')
    ->name('add')
    ->middleware('permission:standard.add');

Route::livewire('/edit/{standard}', 'pages::cms.standard.edit')
    ->name('edit')
    ->middleware('permission:standard.edit');

Route::livewire('/detail/{standard}', 'pages::cms.standard.detail')
    ->name('detail')
    ->middleware('permission:standard.detail');
