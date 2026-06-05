@props([
    'guide' => null,
])

<section class="py-5">
    <div class="container-md py-5">
        <div class="d-grid gap-4">
            <div>
                <span class="small border px-3 py-2 rounded-5 text-body">
                    {{ $guide->category->translate_name }}
                </span>
            </div>
            <div>
                <a draggable="false" class="text-body" href="{{ route('guide.detail', ['slug' => $guide->slug]) }}"
                    wire:navigate>
                    <h1>
                        {{ $guide->translate_title }}
                    </h1>
                </a>
            </div>
            <div>
                <a draggable="false" href="{{ route('guide.detail', ['slug' => $guide->slug]) }}" wire:navigate>
                    <img draggable="false" loading="lazy" decoding="async"
                        class="img-fluid w-100 h-100 object-fit-cover rounded user-select-none pe-none"
                        src="{{ $guide->image_url ?? asset('images/placeholder.png') }}"
                        alt="{{ trans('home.guides.guide') }} - {{ $guide->translate_title }} - {{ config('constants.meta.title') }}"
                        onerror="this.onerror=null; this.src='/images/placeholder.png';" />
                </a>
            </div>
            <div>
                <p>{!! $guide->translate_body !!}</p>
            </div>
        </div>
    </div>
</section>
