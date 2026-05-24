<?php

use App\Libraries\GoogleDrive;
use App\Livewire\Component;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public ?object $guide = null;

    public array $selected = [];

    public string $currentFolderId = '';

    public array $files = [];

    public array $folders = [];

    public function mount()
    {
        $this->currentFolderId = config('constants.folder_id.guide');

        $this->selected = $this->guide?->google_file_id
            ? [
                [
                    'id' => $this->guide->google_file_id,
                    'name' => $this->guide->title,
                    'type' => 'url',
                    'thumbnail' => $this->guide->image_url,
                    'size' => '',
                ],
            ]
            : [];

        $this->loadFiles();
    }

    public function loadFiles()
    {
        $google = new GoogleDrive();

        $this->files = $google->listFiles($this->currentFolderId);
    }

    public function toggleSelect($file)
    {
        $exists = collect($this->selected)->contains(fn($image) => (string) $image['id'] === (string) $file['id']);

        if ($exists) {
            $this->selected = [];
        } else {
            $this->selected = [$file];
        }

        $this->dispatch('imageUpdated', image: $this->selected);
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

            return;
        }

        $this->toggleSelect($file);
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

        $this->currentFolderId = config('constants.folder_id.guide');

        $this->loadFiles();
    }

    public function removeSelected($fileId)
    {
        $this->selected = array_values(array_filter($this->selected, fn($image) => (string) $image['id'] !== (string) $fileId));

        $this->dispatch('imageUpdated', image: $this->selected);
    }
};
?>

<div>
    <x-cms.property.folders-google-drive :folders="$folders" />

    <hr />

    @if (!empty($selected))
        <x-cms.property.selected-google-drive :files="$files" :selected="$selected" />

        <hr />
    @endif

    <x-cms.property.files-google-drive :files="$files" :selected="$selected" />
</div>
