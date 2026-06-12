<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component as LivewireComponent;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Component extends LivewireComponent
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public function boot(): void
    {
        if (session()->has('error')) {
            LivewireAlert::title(session('error.title'))
                ->html(session('error.message'))
                ->withConfirmButton('OK')
                ->confirmButtonColor('#dc3545')
                ->error()
                ->show();
        }

        if (session()->has('success')) {
            LivewireAlert::title(session('success.title'))
                ->html(session('success.message'))
                ->withConfirmButton('OK')
                ->confirmButtonColor('#198754')
                ->success()
                ->show();
        }
    }

    public function alertSuccess(string $title = '', string $body = ''): void
    {
        LivewireAlert::title($title)->html($body)
            ->withConfirmButton('OK')
            ->confirmButtonColor('#198754')
            ->success()
            ->show();
    }

    public function alertError(string $title = '', string $body = ''): void
    {
        LivewireAlert::title($title)
            ->html($body)
            ->withConfirmButton('OK')
            ->confirmButtonColor('#dc3545')
            ->error()
            ->show();
    }

    public function menus(): object
    {
        $pageId = 1;

        return collect([
            [
                'id' => 1,
                'name' => trans('page.module'),
                'icon' => 'fas fa-layer-group',
                'pages' => [
                    [
                        'id' => $pageId++,
                        'menu_id' => 1,
                        'name' => trans('page.contact'),
                        'icon' => 'fas fa-phone',
                        'route' => 'cms.contact.index',
                        'permission' => 'contact',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 1,
                        'name' => trans('page.guide'),
                        'icon' => 'fas fa-newspaper',
                        'route' => 'cms.guide.index',
                        'permission' => 'guide',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 1,
                        'name' => trans('page.guide_category'),
                        'icon' => 'fas fa-tags',
                        'route' => 'cms.guide-category.index',
                        'permission' => 'guide_category',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 1,
                        'name' => trans('page.property'),
                        'icon' => 'fas fa-building',
                        'route' => 'cms.property.index',
                        'permission' => 'property',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 1,
                        'name' => trans('page.property_image'),
                        'icon' => 'fas fa-images',
                        'route' => 'cms.property-image.index',
                        'permission' => 'property_image',
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => trans('page.master'),
                'icon' => 'fas fa-database',
                'pages' => [
                    [
                        'id' => $pageId++,
                        'menu_id' => 2,
                        'name' => trans('page.standard'),
                        'icon' => 'fas fa-clipboard-check',
                        'route' => 'cms.standard.index',
                        'permission' => 'standard',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 2,
                        'name' => trans('page.value'),
                        'icon' => 'fas fa-gem',
                        'route' => 'cms.value.index',
                        'permission' => 'value',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 2,
                        'name' => trans('page.area'),
                        'icon' => 'fas fa-archway',
                        'route' => 'cms.area.index',
                        'permission' => 'area',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 2,
                        'name' => trans('page.district'),
                        'icon' => 'fas fa-city',
                        'route' => 'cms.district.index',
                        'permission' => 'district',
                    ],
                ],
            ],
            [
                'id' => 3,
                'name' => trans('page.access'),
                'icon' => 'fas fa-key',
                'pages' => [
                    [
                        'id' => $pageId++,
                        'menu_id' => 3,
                        'name' => trans('page.oauth'),
                        'icon' => 'fas fa-cogs',
                        'route' => 'cms.oauth.index',
                        'permission' => 'oauth',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 3,
                        'name' => trans('page.permission'),
                        'icon' => 'fas fa-lock-open',
                        'route' => 'cms.permission.index',
                        'permission' => 'permission',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 3,
                        'name' => trans('page.role'),
                        'icon' => 'fas fa-key',
                        'route' => 'cms.role.index',
                        'permission' => 'role',
                    ],
                    [
                        'id' => $pageId++,
                        'menu_id' => 3,
                        'name' => trans('page.user'),
                        'icon' => 'fas fa-user',
                        'route' => 'cms.user.index',
                        'permission' => 'user',
                    ],
                ],
            ],
        ])->when($this->search, function ($menus) {
            $search = str($this->search)->lower();

            return $menus->map(function ($menu) use ($search) {
                $menuMatch = str($menu['name'])->lower()->contains($search);

                $filteredPages = collect($menu['pages'])
                    ->filter(fn ($page) => str($page['name'])->lower()->contains($search))
                    ->values();

                if ($menuMatch) {
                    return $menu;
                }

                if ($filteredPages->isNotEmpty()) {
                    $menu['pages'] = $filteredPages;

                    return $menu;
                }

                return null;
            })
                ->filter()
                ->values();
        });
    }
}
