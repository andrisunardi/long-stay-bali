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

    <x-cms.property.selected-google-drive : :files="$files" :selected="$selected" />

    <hr />

    <x-cms.property.files-google-drive :files="$files" :selected="$selected" />
</div>
