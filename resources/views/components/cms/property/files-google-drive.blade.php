@props([
    'files' => [],
    'selected' => [],
])

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-3">
    @foreach ($files as $file)
        <div class="col" wire:key="file-{{ $file['id'] }}">
            <div class="card h-100 text-center pointer {{ in_array($file['id'], $selected) ? 'bg-primary-subtle' : '' }}"
                wire:click="open(@js($file))">
                @if ($file['type'] === 'folder')
                    <div class="ratio ratio-1x1">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="fas fa-folder fa-2x"></span>
                        </div>
                    </div>
                @else
                    <div class="ratio ratio-1x1">
                        <img draggable="false" loading="lazy" decoding="async"
                            class="img-fluid w-100 h-100 object-fit-cover" src="{{ $file['thumbnail'] }}"
                            alt="Google Drive - {{ $file['id'] }}">
                    </div>
                @endif

                <div class="card-body">
                    <div class="text-truncate">{{ $file['name'] }}</div>
                    <div class="small">{{ Str::filesize($file['size']) }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
