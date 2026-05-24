<?php

use App\Enums\Property\PropertyRentalType;
use App\Livewire\Component;
use App\Livewire\Forms\Property\ListYourPropertyForm;

new class extends Component {
    public ListYourPropertyForm $form;

    public function listYourProperty(): void
    {
        $this->dispatch('open-modal-list-your-property');
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }

    public function submit(): void
    {
        try {
            $this->form->submit();

            $this->alertSuccess(title: trans('index.add') . ' ' . trans('index.success'), body: trans('page.property') . ' ' . trans('message.has_been_successfully_added'));

            $this->dispatch('close-modal-list-your-property');
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function propertyRentalTypes(): array
    {
        return PropertyRentalType::cases();
    }
};
?>

<div>
    <button type="button" class="btn btn-success btn-sm rounded-pill d-none d-xl-inline-flex align-items-center gap-2"
        wire:click="listYourProperty" wire:offline.class="disabled" wire:offline.attr="disabled"
        wire:loading.class="disabled" wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="listYourProperty">
            <span class="fas fa-pen-to-square"></span>
            <span>{{ trans('index.list_your_property') }}</span>
        </span>
        <span wire:loading wire:target="listYourProperty" class="w-100">
            <span class="spinner-border spinner-border-sm"></span>
            <span>{{ trans('index.list_your_property') }}</span>
        </span>
    </button>

    @teleport('body')
        <div class="modal fade" id="modal-list-your-property" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">
                            <span class="fas fa-pencil fa-fw"></span>
                            List Your Property
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <x-form.list-your-property :form="$form" />
                    </div>
                </div>
            </div>
        </div>
    @endteleport
</div>

<script>
    $wire.on('open-modal-list-your-property', () => {
        const modal = new bootstrap.Modal(
            document.getElementById('modal-list-your-property')
        );
        modal.show();
    });
</script>
