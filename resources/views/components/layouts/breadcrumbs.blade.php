<div class="container-fluid">
    <div class="row">
        <div class="col-sm">
            <h4>
                <span class="@yield('icon') fa-fw"></span>
                @yield('title')
            </h4>
        </div>
        <div class="col-sm-auto">
            <nav>
                <ol class="breadcrumb">
                    @unless ($breadcrumbs->isEmpty())
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if (!is_null($breadcrumb->url) && !$loop->last)
                                <li class="breadcrumb-item">
                                    <a draggable="false" class="text-body" href="{{ $breadcrumb->url }}">
                                        <span class="{{ $breadcrumb->icon }}"></span>
                                        {{ $breadcrumb->title }}
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item active">
                                    <span class="{{ $breadcrumb->icon }}"></span>
                                    {{ $breadcrumb->title }}
                                </li>
                            @endif
                        @endforeach
                    @endunless
                </ol>
            </nav>
        </div>
    </div>
</div>
