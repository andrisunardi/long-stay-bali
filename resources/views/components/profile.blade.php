<?php

use App\Livewire\Component;

new class extends Component {
    public function languages(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'en',
                'name' => 'English',
                'image_url' => asset('images/flag/en.svg'),
            ],
            [
                'id' => 2,
                'code' => 'id',
                'name' => 'Indonesia',
                'image_url' => asset('images/flag/id.svg'),
            ],
            [
                'id' => 3,
                'code' => 'zh',
                'name' => 'Chinese',
                'image_url' => asset('images/flag/zh.svg'),
            ],
        ];
    }
};
?>

<div>
    <button type="button" class="btn d-sm-flex align-items-sm-center gap-sm-1" data-bs-toggle="offcanvas"
        data-bs-target="#profile">
        <span class="fas fa-user-circle fa-fw"></span>
        <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>

    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="profile">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">
                {{ trans('index.profile_menu') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <div class="row align-items-center g-3">
                <div class="col-3">
                    <div class="ratio ratio-1x1">
                        <img draggable="false" loading="lazy" decoding="async"
                            class="img-fluid w-100 h-100 rounded-circle object-fit-cover"
                            src="{{ Auth::user()->image_url ?? asset('images/user.png') }}"
                            alt="{{ trans('page.user') }} - {{ Auth::user()->id }}"
                            onerror="this.src='{{ asset('images/user.png') }}'" />
                    </div>
                </div>

                <div class="col-9">
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <div class="small">{{ Auth::user()->username }}</div>
                    <div class="small">{{ Auth::user()->roles->pluck('name')->join(', ') }}</div>
                </div>
            </div>

            <hr />

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a draggable="false" class="nav-link {{ Route::is('cms.profile.index') ? 'active' : '' }}"
                        href="{{ route('cms.profile.index') }}">
                        <span class="fas fa-user fa-fw"></span>
                        {{ trans('page.profile') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a draggable="false" class="nav-link {{ Route::is('cms.profile.edit-profile') ? 'active' : '' }}"
                        href="{{ route('cms.profile.edit-profile') }}">
                        <span class="fas fa-user-edit fa-fw"></span>
                        {{ trans('page.edit_profile') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a draggable="false"
                        class="nav-link {{ Route::is('cms.profile.change-password') ? 'active' : '' }}"
                        href="{{ route('cms.profile.change-password') }}">
                        <span class="fas fa-user-lock fa-fw"></span>
                        {{ trans('page.change_password') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a draggable="false" class="nav-link {{ Route::is('cms.profile.setting') ? 'active' : '' }}"
                        href="{{ route('cms.profile.setting') }}">
                        <span class="fas fa-user-gear fa-fw"></span>
                        {{ trans('page.setting') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a draggable="false" class="nav-link {{ Route::is('cms.profile.activity') ? 'active' : '' }}"
                        href="{{ route('cms.profile.activity') }}">
                        <span class="fas fa-user-clock fa-fw"></span>
                        {{ trans('page.activity') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a draggable="false" class="nav-link" href="{{ route('cms.logout') }}">
                        <span class="fas fa-sign-out-alt fa-fw"></span>
                        {{ trans('page.logout') }}
                    </a>
                </li>
            </ul>

            <hr />

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-light border-dark w-100" data-bs-theme-value="light">
                        <span class="fas fa-sun fa-fw"></span>
                        {{ trans('theme.light') }}
                    </button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-dark border-light w-100" data-bs-theme-value="dark">
                        <span class="fas fa-moon fa-fw"></span>
                        {{ trans('theme.dark') }}
                    </button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-secondary w-100" data-bs-theme-value="auto">
                        <span class="fas fa-circle-half-stroke fa-fw"></span>
                        {{ trans('theme.auto') }}
                    </button>
                </div>
            </div>

            <hr />

            <div class="dropdown">
                <button class="btn btn-outline-body icon-link dropdown-toggle justify-content-between w-100"
                    type="button" data-bs-toggle="dropdown">
                    <span class="d-flex gap-2">
                        <img draggable="false" loading="lazy" decoding="async" class="user-select-none pe-none"
                            width="20" src="{{ asset('images/flag/' . app()->getLocale() . '.svg') }}"
                            alt="{{ trans('index.flag') }} - {{ app()->getLocale() }} - {{ config('constants.meta.title') }}" />
                        <span class="text-uppercase">
                            {{ collect($this->languages())->firstWhere('code', app()->getLocale())['name'] }}
                        </span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end w-100 mt-3">
                    <li>
                        <h6 class="dropdown-header">{{ trans('index.change_language') }}</h6>
                    </li>
                    @foreach ($this->languages() as $language)
                        <li wire:key="language-{{ $language['id'] }}">
                            <a draggable="false" class="dropdown-item icon-link"
                                href="{{ route('locale', ['locale' => $language['code']]) }}">
                                <img draggable="false" loading="lazy" decoding="async" class="user-select-none pe-none"
                                    width="20" src="{{ $language['image_url'] }}"
                                    alt="{{ trans('index.flag') }} {{ $language['code'] }} - {{ config('constants.meta.title') }}" />
                                <span class="text-uppercase">{{ $language['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
