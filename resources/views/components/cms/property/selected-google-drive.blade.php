@props([
    'files' => [],
    'selected' => [],
])

@if (count($selected))
    <div class="mb-4">
        <div class="row g-4">
            @foreach ($selected as $key => $imageId)
                @php
                    $file = collect($files)->firstWhere('id', $imageId);
                @endphp
                @if ($file)
                    <div class="col-4 col-sm-3 col-lg-2 col-xl-1" wire:key="image-{{ $file['id'] }}">
                        <div class="position-relative">
                            <a draggable="false" role="button" data-bs-toggle="modal"
                                data-bs-target="#modal-image-{{ $file['id'] }}">
                                <div class="ratio ratio-1x1">
                                    <img src="{{ $file['thumbnail'] }}" class="img-fluid object-fit-cover rounded">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded">
                                    </div>
                                </div>
                            </a>

                            <div class="position-absolute top-50 start-50 translate-middle text-white">
                                <a draggable="false" role="button" data-bs-toggle="modal"
                                    data-bs-target="#modal-image-{{ $file['id'] }}">
                                    {{ $key + 1 }}
                                </a>
                            </div>

                            <a draggable="false" role="button"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-5 bg-danger">
                                x
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        @foreach ($selected as $key => $imageId)
            @php
                $file = collect($files)->firstWhere('id', $imageId);
            @endphp
            @if ($file)
                <x-cms.modal.images-google-drive :image="$file['id']" />
            @endif
        @endforeach
    </div>
@endif
