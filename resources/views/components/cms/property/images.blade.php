<?php

use App\Libraries\GoogleDrive;
use App\Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Session;

new #[Lazy] class extends Component {
    public array $selectedImages = [];

    public ?string $currentFolderId = '13alt2Sqn0xIsndoTa0ZG1jSqns1jsBg3';

    public array $files = [];

    public array $folderStack = [];

    public function mount()
    {
        $this->loadFiles();
    }

    public function loadFiles()
    {
        $google = new GoogleDrive();
        $this->files = $google->listFiles($this->currentFolderId);
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedImages)) {
            $this->selectedImages = array_values(array_filter($this->selectedImages, fn($i) => $i !== $id));
        } else {
            $this->selectedImages[] = $id;
        }
        $this->dispatch('imagesUpdated', images: $this->selectedImages);
    }

    public function open($file)
    {
        if ($file['type'] === 'folder') {
            $this->folderStack[] = [
                'id' => $this->currentFolderId,
                'name' => $file['name'],
            ];

            $this->currentFolderId = $file['id'];
            $this->currentFolderName = $file['name'];

            $this->loadFiles();
        } else {
            $this->toggleSelect($file['id']);
        }
    }

    public function goTo($index)
    {
        $folder = $this->folderStack[$index];

        $this->currentFolderId = $folder['id'];
        $this->folderStack = array_slice($this->folderStack, 0, $index);

        $this->loadFiles();
    }

    public function goRoot()
    {
        $this->folderStack = [];
        $this->currentFolderId = $this->rootFolderId;

        $this->loadFiles();
    }
};
?>

<div>
    <nav aria-label="breadcrumb" class="mb-3 border-bottom">
        <ol class="breadcrumb">
            @if (!count($folderStack))
                <li class="breadcrumb-item active">
                    <span class="fas fa-home fa-fw"></span>
                    {{ trans('page.home') }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="#" wire:click.prevent="goRoot">
                        <span class="fas fa-home fa-fw"></span>
                        {{ trans('page.home') }}
                    </a>
                </li>
                @foreach ($folderStack as $index => $folder)
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                        @if ($loop->last)
                            {{ $folder['name'] }}
                        @else
                            <a href="#" wire:click.prevent="goTo({{ $index }})">
                                {{ $folder['name'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            @endif
        </ol>
    </nav>

    @if (count($selectedImages))
        <div class="mb-4">
            {{-- <div class="d-flex flex-wrap gap-3">
                @foreach ($selectedImages as $index => $imageId)
                    @php
                        $file = collect($files)->firstWhere('id', $imageId);
                    @endphp

                    @if ($file)
                        <div class="position-relative" style="width: 100px;">
                            <div class="ratio ratio-1x1">
                                <img src="{{ $file['thumbnail'] }}" class="img-fluid object-fit-cover rounded">
                            </div>

                            <span
                                class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary">
                                {{ $index + 1 }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div> --}}
            <div class="row g-4">
                @foreach ($selectedImages as $key => $imageId)
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
                                        <div
                                            class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded">
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

            @foreach ($selectedImages as $key => $imageId)
                @php
                    $file = collect($files)->firstWhere('id', $imageId);
                @endphp
                @if ($file)
                    <x-cms.modal.image-google-drive :image="$file['id']" />
                @endif
            @endforeach
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-3">
        @foreach ($files as $file)
            <div class="col" wire:key="file-{{ $file['id'] }}">
                <div class="card h-100 text-center pointer {{ in_array($file['id'], $selectedImages) ? 'bg-primary-subtle' : '' }}"
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
                                alt="Google Drive">
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
</div>
