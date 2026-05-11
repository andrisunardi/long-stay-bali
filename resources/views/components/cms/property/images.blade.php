<?php

use App\Libraries\GoogleDrive;
use App\Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Session;

new #[Lazy] class extends Component {
    public ?object $property = null;

    public array $selected = [];

    public string $currentFolderId = '';

    public array $files = [];

    public array $folders = [];

    public function mount()
    {
        $this->currentFolderId = config('constants.folder_id.property');
        $this->loadFiles();
    }

    public function loadFiles()
    {
        $google = new GoogleDrive();
        $this->files = $google->listFiles($this->currentFolderId);
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_values(array_filter($this->selected, fn($i) => $i !== $id));
        } else {
            $this->selected[] = $id;
        }
        $this->dispatch('imagesUpdated', images: $this->selected);
    }

    public function open($file)
    {
        if ($file['type'] === 'folder') {
            $this->folders[] = [
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
        $folder = $this->folders[$index];

        $this->currentFolderId = $folder['id'];
        $this->folders = array_slice($this->folders, 0, $index);

        $this->loadFiles();
    }

    public function home()
    {
        $this->folders = [];
        $this->currentFolderId = config('constants.folder_id.property');
        $this->loadFiles();
    }
};
?>

<div>

    <x-cms.property.folders-google-drive :folders="$folders" />

    <hr />

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

    <x-cms.property.files-google-drive :files="$files" :selected="$selected" />
</div>
