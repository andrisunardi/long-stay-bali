<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\PropertyImage\PropertyImageEditForm;
use App\Models\PropertyImage;
use App\Services\PropertyService;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Edit | Property Image')] class extends Component {
    public PropertyImage $propertyImage;

    public PropertyImageEditForm $form;

    public function mount(PropertyImage $propertyImage): void
    {
        $this->propertyImage = $propertyImage;
        $this->form->set(propertyImage: $propertyImage);
    }

    public function resetForm(): void
    {
        $this->form->set(propertyImage: $this->propertyImage);
    }

    public function submit(): void
    {
        try {
            $this->form->submit(propertyImage: $this->propertyImage);

            session()->flash('success', [
                'title' => trans('index.edit') . ' ' . trans('index.success'),
                'message' => trans('page.property_image') . ' ' . trans('message.has_been_successfully_edited'),
            ]);

            $this->redirect(route('cms.property-image.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.edit') . ' ' . trans('failed'), body: $errors);
        }
    }

    public function properties(): object
    {
        $service = new PropertyService();
        return $service->index(orderBy: 'name', sortBy: 'asc', paginate: false);
    }
};
?>

@section('title', 'Property Image')

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-success">
            <span class="fas fa-edit fa-fw"></span>
            {{ trans('index.edit') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-success w-100" href="{{ route('cms.property-image.index') }}"
                        wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <x-alert-error />

            <form wire:submit.prevent="submit" role="form" autocomplete="off">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="property_id">
                                    {{ trans('validation.attributes.property_id') }}
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-building fa-fw "></span>
                                    </div>
                                    <select class="form-select select2" id="property_id" name="property_id"
                                        wire:key="form.property_id" wire:model.lazy="property_id"
                                        wire:offline.class="disabled" wire:offline.attr="disabled"
                                        wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <option value="">
                                            {{ trans('index.select') }}
                                            {{ trans('validation.attributes.property_id') }}
                                        </option>
                                        @foreach ($this->properties() as $property)
                                            <option value="{{ $property->id }}"
                                                {{ $property->id == $form->property_id ? 'selected' : '' }}
                                                wire:key="property-{{ $property->id }}">
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('form.property_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="name">
                                    {{ trans('validation.attributes.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-images fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name"
                                        minlength="1" maxlength="50"
                                        placeholder="{{ trans('index.ex') }}. Master Bedroom" required
                                        wire:model="form.name" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50
                                </div>
                                @error('form.name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="description">
                                    {{ trans('validation.attributes.description') }}
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-file-lines fa-fw "></span>
                                    </div>
                                    <textarea class="form-control" id="description" name="description" minlength="1" maxlength="65535"
                                        placeholder="{{ trans('index.ex') }}. Luxury Bedroom" wire:model="form.description" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                    </textarea>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 65.535
                                </div>
                                @error('form.description')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="image">
                                    {{ trans('validation.attributes.image') }}
                                </label>
                                <div id="drop-zone"
                                    class="border border-2 rounded p-4 text-center"
                                    ondragover="event.preventDefault(); this.classList.add('border-success','bg-success-subtle')"
                                    ondragleave="this.classList.remove('border-success','bg-success-subtle')"
                                    ondrop="handleImageDrop(event)">
                                    <span class="fas fa-cloud-upload-alt fa-2x text-muted d-block mb-2"></span>
                                    <span class="text-muted small">Drag &amp; drop image here or</span>
                                    <label for="image" class="btn btn-sm btn-outline-success ms-1 mb-0">Browse</label>
                                    <input type="file" class="d-none" id="image" name="image"
                                        accept="image/*,capture=camera,image/jpg,image/jpeg,image/png,image/gif,image/webp"
                                        wire:model="form.image" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.format') }} : jpg .jpeg .png .gif .webp,
                                    {{ trans('helper.max_size') }} : 12 MB
                                </div>
                                @error('form.image')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($form->image)
                                <div>
                                    <div class="alert alert-info w-100" role="alert" wire:loading
                                        wire:target="form.image">
                                        {{ trans('message.please_wait_until_the_uploading_finished') }}
                                    </div>
                                    <div class="ratio ratio-1x1">
                                        <img draggable="false" loading="lazy" decoding="async"
                                            class="rounded object-fit-cover"
                                            src="{{ $form->image->temporaryUrl() }}" alt="Image Temporary Url"
                                            onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                    </div>
                                </div>
                            @elseif ($propertyImage->image_url)
                                <div class="ratio ratio-1x1">
                                    <a draggable="false" href="{{ $propertyImage->image_url }}" target="_blank">
                                        <img draggable="false" loading="lazy" decoding="async"
                                            class="rounded object-fit-cover w-100 h-100"
                                            src="{{ $propertyImage->image_url }}"
                                            alt="{{ trans('page.property_image') }} - {{ $propertyImage->id }}"
                                            onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($propertyImage->property && $propertyImage->property->images->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <span class="fas fa-images fa-fw"></span>
                            {{ trans('page.property_image') }} — {{ $propertyImage->property->name }}
                        </label>
                        <div class="row row-cols-3 row-cols-sm-4 row-cols-md-6 g-2">
                            @foreach ($propertyImage->property->images->sortBy('position') as $img)
                                <div class="col">
                                    <div class="ratio ratio-1x1">
                                        <a draggable="false" href="{{ $img->image_url }}" target="_blank"
                                            class="d-block {{ $img->id === $propertyImage->id ? 'border border-3 border-success rounded' : '' }}">
                                            <img draggable="false" loading="lazy" decoding="async"
                                                class="rounded object-fit-cover w-100 h-100"
                                                src="{{ $img->image_url }}"
                                                alt="{{ $img->name }}"
                                                title="{{ $img->name }}"
                                                onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                        </a>
                                    </div>
                                    <div class="text-center mt-1">
                                        <small class="text-muted text-truncate d-block">{{ $img->name }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <hr />

                <div class="row">
                    <div class="col-6 col-sm-auto">
                        <button type="submit" class="btn btn-success w-100" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">
                                <span class="fas fa-save fa-fw"></span>
                                {{ trans('index.save') }}
                            </span>
                            <span wire:loading wire:target="submit" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.save') }}
                            </span>
                        </button>
                    </div>
                    <div class="col-6 col-sm-auto">
                        <button type="button" class="btn btn-warning w-100" wire:click="resetForm"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetForm">
                                <span class="fas fa-eraser fa-fw"></span>
                                {{ trans('index.reset') }}
                            </span>
                            <span wire:loading wire:target="resetForm" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.reset') }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@script
    <script>
        $("#property_id").on("change", function() {
            @this.set("form.property_id", $(this).val())
        })

        function handleImageDrop(event) {
            event.preventDefault()
            const dropZone = document.getElementById('drop-zone')
            dropZone.classList.remove('border-success', 'bg-success-subtle')
            const file = event.dataTransfer.files[0]
            if (!file) return
            const input = document.getElementById('image')
            const dt = new DataTransfer()
            dt.items.add(file)
            input.files = dt.files
            input.dispatchEvent(new Event('change'))
        }
    </script>
@endscript
