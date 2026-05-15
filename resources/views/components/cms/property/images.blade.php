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

        $this->selected = !empty($this->selected)
            ? $this->selected
            : ($this->property?->images?->count()
                ? $this->property->images
                    ->sortBy('position')
                    ->map(
                        fn($propertyImage) => [
                            'id' => $propertyImage->google_file_id ?: $propertyImage->id,
                            'name' => $propertyImage->name,
                            'type' => 'url',
                            'thumbnail' => $propertyImage->image_url,
                            'size' => '',
                        ],
                    )
                    ->values()
                    ->toArray()
                : []);

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
            $this->selected = array_values(
                array_filter(
                    $this->selected,

                    fn($image) => (string) $image['id'] !== (string) $file['id'],
                ),
            );
        } else {
            $this->selected[] = $file;
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
            $this->toggleSelect($file);
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

    public function removeSelected($fileId)
    {
        $this->selected = array_values(array_filter($this->selected, fn($image) => (string) $image['id'] !== (string) $fileId));

        $this->dispatch('imagesUpdated', images: $this->selected);
    }

    public function moveLeft($index)
    {
        if ($index <= 0) {
            return;
        }

        [$this->selected[$index - 1], $this->selected[$index]] = [$this->selected[$index], $this->selected[$index - 1]];

        $this->dispatch('imagesUpdated', images: $this->selected);
    }

    public function moveRight($index)
    {
        if ($index >= count($this->selected) - 1) {
            return;
        }

        [$this->selected[$index + 1], $this->selected[$index]] = [$this->selected[$index], $this->selected[$index + 1]];

        $this->dispatch('imagesUpdated', images: $this->selected);
    }
};
?>

<div>
    <x-cms.property.folders-google-drive :folders="$folders" />

    <hr />

    @if (count($selected))
        <x-cms.property.selected-google-drive : :files="$files" :selected="$selected" />

        <hr />
    @endif

    <x-cms.property.files-google-drive :files="$files" :selected="$selected" />
</div>
