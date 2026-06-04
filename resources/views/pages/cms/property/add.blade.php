<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyElectricity;
use App\Enums\Property\PropertyLivingStyle;
use App\Enums\Property\PropertyOrientation;
use App\Enums\Property\PropertyOwnerPriceFlexibility;
use App\Enums\Property\PropertyPowerBackup;
use App\Enums\Property\PropertyRentalType;
use App\Enums\Property\PropertyStatus;
use App\Enums\Property\PropertyTab;
use App\Enums\Property\PropertyTargetProfile;
use App\Enums\Property\PropertyWaterSource;
use App\Livewire\Component;
use App\Livewire\Forms\CMS\Property\PropertyAddForm;
use App\Models\Contact;
use App\Services\AreaService;
use App\Services\ContactService;
use App\Services\DistrictService;
use App\Services\UserService;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

new #[Title('Add | Property')] class extends Component {
    public PropertyAddForm $form;

    public int $tab = PropertyTab::PropertyIndentity->value;

    public string $owner_name = '';

    public string $owner_phone = '';

    public string $owner_email = '';

    public string $owner_representative_name = '';

    public string $owner_representative_phone = '';

    public string $owner_representative_email = '';

    public function mount(): void
    {
        $this->form->availability_date = today()->toDateString();
        $this->form->visit_date = today()->toDateString();
        $this->dispatch('resetForm');

        if (Auth::user()->hasRole('Agent')) {
            $this->form->user_id = Auth::id();
        }
    }

    public function changeTab(int $tab): void
    {
        $this->tab = $tab;
    }

    public function updatedFormOwnerId(): void
    {
        $contact = Contact::find($this->form->owner_id);

        if ($contact) {
            $this->owner_name = $contact->name;
            $this->owner_phone = $contact->phone;
            $this->owner_email = $contact->email;
        } else {
            $this->reset(['owner_name', 'owner_phone', 'owner_email']);
        }
    }

    public function updatedFormOwnerRepresentativeId(): void
    {
        $contact = Contact::find($this->form->owner_representative_id);

        if ($contact) {
            $this->owner_representative_name = $contact->name;
            $this->owner_representative_phone = $contact->phone;
            $this->owner_representative_email = $contact->email;
        } else {
            $this->reset(['owner_representative_name', 'owner_representative_phone', 'owner_representative_email']);
        }
    }

    public function ownerSubmit(): void
    {
        $form = $this->validate([
            'owner_name' => 'required|string|min:1|max:50',
            'owner_phone' => 'nullable|required_without:owner_email|string|min:1|max:20|unique:contacts,phone',
            'owner_email' => 'nullable|required_without:owner_phone|email:rfc,dns|min:1|max:50|unique:contacts,email',
        ]);

        $data = [];
        $data['name'] = $form['owner_name'];
        $data['phone'] = $form['owner_phone'];
        $data['email'] = $form['owner_email'];
        $data['client_type'] = 'Owner';

        $service = new ContactService();
        $contact = $service->create($data);

        $this->form->owner_id = $contact->id;

        $this->alertSuccess(title: trans('index.add') . ' ' . trans('page.contact') . ' ' . trans('index.success'), body: trans('page.contact') . ' ' . trans('message.has_been_successfully_added'));
    }

    public function ownerRepresentativeSubmit(): void
    {
        $form = $this->validate([
            'owner_representative_name' => 'required|string|min:1|max:50',
            'owner_representative_phone' => 'nullable|required_without:owner_representative_email|string|min:1|max:20|unique:contacts,phone',
            'owner_representative_email' => 'nullable|required_without:owner_representative_phone|email:rfc,dns|min:1|max:50|unique:contacts,email',
        ]);

        $data = [];
        $data['name'] = $form['owner_representative_name'];
        $data['phone'] = $form['owner_representative_phone'];
        $data['email'] = $form['owner_representative_email'];
        $data['client_type'] = 'Owner Representative';

        $service = new ContactService();
        $contact = $service->create($data);

        $this->form->owner_representative_id = $contact->id;

        $this->alertSuccess(title: trans('index.add') . ' ' . trans('page.contact') . ' ' . trans('index.success'), body: trans('page.contact') . ' ' . trans('message.has_been_successfully_added'));
    }

    #[On('imagesUpdated')]
    public function setImages($images): void
    {
        $this->form->images = $images;
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }

    public function submit(): void
    {
        try {
            $this->form->submit();

            session()->flash('success', [
                'title' => trans('index.add') . ' ' . trans('index.success'),
                'message' => trans('page.property') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.property.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function users(): object
    {
        $service = new UserService();
        return $service->index(roleName: 'Agent', isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function areas(): object
    {
        $service = new AreaService();
        return $service->index(districtId: $this->form->district_id, isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function contacts(): object
    {
        $service = new ContactService();
        return $service->index(orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function propertyBedrooms(): array
    {
        return PropertyBedroom::cases();
    }

    public function propertyLivingStyles(): array
    {
        return PropertyLivingStyle::cases();
    }

    public function propertyRentalTypes(): array
    {
        return PropertyRentalType::cases();
    }

    public function propertyOwnerPriceFlexibility(): array
    {
        return PropertyOwnerPriceFlexibility::cases();
    }

    public function propertyOrientations(): array
    {
        return PropertyOrientation::cases();
    }

    public function propertyPowerBackups(): array
    {
        return PropertyPowerBackup::cases();
    }

    public function propertyWaterSources(): array
    {
        return PropertyWaterSource::cases();
    }

    public function propertyElectricities(): array
    {
        return PropertyElectricity::cases();
    }

    public function propertyTargetProfiles(): array
    {
        return PropertyTargetProfile::cases();
    }

    public function propertyStatuses(): array
    {
        return PropertyStatus::cases();
    }

    public function propertyTabs(): array
    {
        return PropertyTab::cases();
    }
};
?>

@section('title', trans('page.property'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.property.index') }}"
                        wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span> {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr class="mb-0" />

            <x-alert-error />

            <form wire:submit.prevent="submit" role="form" autocomplete="off">

                <x-cms.property.menu :tab="$tab" />

                <x-cms.property.form :form="$form" :tab="$tab" :type="request()->segment(3)" />

                <hr />

                <div class="row">
                    <div class="col-6 col-sm-auto">
                        <button type="submit" class="btn btn-primary w-100" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">
                                <span class="fas fa-paper-plane fa-fw"></span>
                                {{ trans('index.submit') }}
                            </span>
                            <span wire:loading wire:target="submit" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.submit') }}
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
        document.addEventListener("livewire:initialized", () => {
            $("#user_id").on("change", function() {
                @this.set("form.user_id", $(this).val())
            })

            $("#district_id").on("change", function() {
                @this.set("form.district_id", $(this).val())
            })

            $("#area_id").on("change", function() {
                @this.set("form.area_id", $(this).val())
            })

            $("#status").on("change", function() {
                @this.set("form.status", $(this).val())
            })

            const map = L.map('map').setView([-6.2, 106.8], 12);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            let marker = L.marker([-6.2, 106.8], {
                draggable: true
            }).addTo(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        map.setView([lat, lng], 15);

                        marker.setLatLng([lat, lng]);

                        @this.set('form.latitude', lat);
                        @this.set('form.longitude', lng);

                        console.log('My location:', lat, lng);
                    },
                    function(error) {
                        console.log('Location access denied or unavailable');
                    }
                );
            } else {
                console.log('Geolocation not supported');
            }

            marker.on('dragend', function() {
                const position = marker.getLatLng();
                console.log(position.lat, position.lng);
                @this.set('form.latitude', e.latitude);
                @this.set('form.longitude', e.longitude);
            });
        });
    </script>
@endscript
