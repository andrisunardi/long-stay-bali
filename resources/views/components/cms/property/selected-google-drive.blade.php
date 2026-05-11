@props([
    'files' => [],
    'selected' => [],
])

<div class="row g-4">
    @foreach ($selected as $key => $row)
        @php
            $file = collect($files)->firstWhere('id', $row['id']);
        @endphp

        @if ($file)
            <div class="col-4 col-sm-3 col-lg-2 col-xl-1" wire:key="image-{{ $file['id'] }}">
                <div class="position-relative">
                    <a draggable="false" role="button" data-bs-toggle="modal"
                        data-bs-target="#modal-image-{{ $file['id'] }}">
                        <div class="ratio ratio-1x1">
                            <img draggable="false" loading="lazy" decoding="async"
                                class="img-fluid w-100 h-100 object-fit-cover rounded" src="{{ $file['thumbnail'] }}"
                                alt="Google Drive - {{ $file['id'] }}">

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

                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 d-flex gap-1">
                        @if ($key > 0)
                            <a draggable="false" role="button" class="btn btn-sm btn-light rounded-pill"
                                wire:click.stop="moveLeft({{ $key }})">
                                <span class="fas fa-arrow-left"></span>
                            </a>
                        @endif

                        @if ($key < count($selected) - 1)
                            <a draggable="false" role="button" class="btn btn-sm btn-light rounded-pill"
                                wire:click.stop="moveRight({{ $key }})">
                                <span class="fas fa-arrow-right"></span>
                            </a>
                        @endif
                    </div>

                    <a draggable="false" role="button"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger icon-link p-1"
                        wire:click="removeSelected('{{ $file['id'] }}')" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="removeSelected('{{ $file['id'] }}')">
                            <span class="fas fa-x fa-fw"></span>
                        </span>
                        <span wire:loading wire:target="removeSelected('{{ $file['id'] }}')" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </a>
                </div>
            </div>
        @else
            <div class="col-4 col-sm-3 col-lg-2 col-xl-1" wire:key="image-{{ $row['id'] }}">
                <div class="position-relative">
                    <a draggable="false" role="button" data-bs-toggle="modal"
                        data-bs-target="#modal-image-{{ $row['id'] }}">
                        <div class="ratio ratio-1x1">
                            <img draggable="false" loading="lazy" decoding="async"
                                class="img-fluid w-100 h-100 object-fit-cover rounded" src="{{ $row['thumbnail'] }}"
                                alt="Google Drive - {{ $row['id'] }}">

                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded">
                            </div>
                        </div>
                    </a>

                    <div class="position-absolute top-50 start-50 translate-middle text-white">
                        <a draggable="false" role="button" data-bs-toggle="modal"
                            data-bs-target="#modal-image-{{ $row['id'] }}">
                            {{ $key + 1 }}
                        </a>
                    </div>

                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-2 d-flex gap-1">
                        @if ($key > 0)
                            <a draggable="false" role="button" class="btn btn-sm btn-light rounded-pill"
                                wire:click.stop="moveLeft({{ $key }})">
                                <span class="fas fa-arrow-left"></span>
                            </a>
                        @endif

                        @if ($key < count($selected) - 1)
                            <a draggable="false" role="button" class="btn btn-sm btn-light rounded-pill"
                                wire:click.stop="moveRight({{ $key }})">
                                <span class="fas fa-arrow-right"></span>
                            </a>
                        @endif
                    </div>

                    <a draggable="false" role="button"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger icon-link p-1"
                        wire:click="removeSelected('{{ $row['id'] }}')" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="removeSelected('{{ $row['id'] }}')">
                            <span class="fas fa-x fa-fw"></span>
                        </span>
                        <span wire:loading wire:target="removeSelected('{{ $row['id'] }}')" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
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
        <x-cms.modal.image-google-drive :image="$file['id']" />
    @endif
@endforeach
