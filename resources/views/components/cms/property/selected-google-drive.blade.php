@props([
    'files' => [],
    'selected' => [],
])

<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-4">
    @foreach ($selected as $key => $row)
        @php
            $file = collect($files)->firstWhere('id', $row['id']);
        @endphp

        @if ($file)
            <div class="col" wire:key="image-{{ $file['id'] }}">
                <div class="position-relative">
                    <a draggable="false" role="button" data-bs-toggle="modal"
                        data-bs-target="#modal-image-{{ $key }}">
                        <div class="ratio ratio-16x9">
                            <img draggable="false" loading="lazy" decoding="async"
                                class="img-fluid w-100 h-100 object-fit-cover rounded" src="{{ $file['thumbnail'] }}"
                                alt="Google Drive - {{ $file['id'] }}">
                        </div>
                    </a>

                    <div class="position-absolute top-0 start-0 text-white p-2">
                        <a draggable="false" role="button" data-bs-toggle="modal"
                            data-bs-target="#modal-image-{{ $key }}">
                            <span class="badge rounded-pill text-bg-light">
                                {{ $key + 1 }}
                            </span>
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

                <div class="text-center mt-2">{{ $file['name'] }}</div>
                <div class="text-center">{{ $file['resolution'][0] ?? 0 }} x {{ $file['resolution'][1] ?? 0 }}</div>
                <div class="text-center">{{ Str::filesize($row['size']) }}</div>

                <x-cms.modal.image-google-drive :id="$key" :image="'https://lh3.googleusercontent.com/d/' . $file['id']" />
            </div>
        @else
            <div class="col" wire:key="image-{{ $row['id'] }}">
                <div class="position-relative">
                    <a draggable="false" role="button" data-bs-toggle="modal"
                        data-bs-target="#modal-image-{{ $key }}">
                        <div class="ratio ratio-16x9">
                            <img draggable="false" loading="lazy" decoding="async"
                                class="img-fluid w-100 h-100 object-fit-cover rounded" src="{{ $row['thumbnail'] }}"
                                alt="Google Drive - {{ $row['id'] }}">
                        </div>
                    </a>

                    <div class="position-absolute top-0 start-0 text-white p-2">
                        <a draggable="false" role="button" data-bs-toggle="modal"
                            data-bs-target="#modal-image-{{ $key }}">
                            <span class="badge rounded-pill text-bg-light">
                                {{ $key + 1 }}
                            </span>
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

                <div class="text-center mt-2">{{ $row['name'] }}</div>
                <div class="text-center">
                    {{ $row['resolution']['width'] ?? 0 }} x {{ $row['resolution']['height'] ?? 0 }}
                </div>
                <div class="text-center">
                    {{ $row['mime'] ?? "-" }} - {{ Str::filesize($row['size']) }}
                </div>

                <x-cms.modal.image-google-drive :id="$key" :image="$row['thumbnail']" />
            </div>
        @endif
    @endforeach
</div>
