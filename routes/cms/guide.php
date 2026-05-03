<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::cms.guide')
    ->name('index')
    ->middleware('permission:guide');

Route::livewire('/add', 'pages::cms.guide.add')
    ->name('add')
    ->middleware('permission:guide.add');

Route::livewire('/edit/{guide}', 'pages::cms.guide.edit')
    ->name('edit')
    ->middleware('permission:guide.edit');

Route::livewire('/detail/{guide}', 'pages::cms.guide.detail')
    ->name('detail')
    ->middleware('permission:guide.detail');
