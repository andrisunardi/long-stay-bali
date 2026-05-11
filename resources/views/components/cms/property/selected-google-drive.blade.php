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
