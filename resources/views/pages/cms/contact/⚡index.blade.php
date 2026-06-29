<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Exports\ContactExport;
use App\Livewire\Component;
use App\Models\Area;
use App\Models\Contact;
use App\Services\AreaService;
use App\Services\ContactService;
use App\Services\DistrictService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Contact')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $district_id = '';

    #[Url(except: '')]
    public string $area_id = '';

    #[Url(except: '')]
    public string $bedroom = '';

    #[Url(except: '')]
    public string $rental_type = '';

    #[Url(except: '')]
    public string $start_date = '';

    #[Url(except: '')]
    public string $end_date = '';

    public function mount(): void
    {
        $this->district_id = Area::find($this->area_id)->district_id ?? '';
    }

    public function updating(): void
    {
        $this->resetPage();
    }

    public function updated(): void
    {
        $this->district_id = Area::find($this->area_id)->district_id ?? '';
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'district_id', 'area_id', 'bedroom', 'rental_type', 'start_date', 'end_date']);
    }

    public function delete(Contact $contact): void
    {
        $service = new ContactService();
        $service->delete(contact: $contact);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.contact') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function areas(): object
    {
        $service = new AreaService();
        return $service->index(districtId: $this->district_id, isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function propertyBedrooms(): array
    {
        return PropertyBedroom::cases();
    }

    public function propertyRentalTypes(): array
    {
        return PropertyRentalType::cases();
    }

    public function contacts(bool $paginate = true): object
    {
        $service = new ContactService();
        $contacts = $service->index(search: $this->search, districtId: $this->district_id, areaId: $this->area_id, bedroom: $this->bedroom, rentalType: $this->rental_type, startDate: $this->start_date, endDate: $this->end_date, paginate: $paginate);
        $contacts->loadMissing(['owners', 'ownerRepresentatives']);

        return $contacts;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.contact') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new ContactService();
        $contacts = $service->index(startDate: $this->start_date, endDate: $this->end_date, orderBy: 'id', sortBy: 'asc', paginate: false);
        $contacts->loadMissing(['owners', 'ownerRepresentatives', 'createdBy', 'updatedBy']);

        return Excel::download(new ContactExport(contacts: $contacts), trans('page.contact') . '.xlsx');
    }
};
?>

@section('title', trans('page.contact'))

<div class="container-fluid">
    <div class="card my-3">
        <div class="card-header text-bg-primary">
            <span class="fas fa-search fa-fw"></span>
            {{ trans('index.search') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="d-grid gap-3">
                <div class="row g-3">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-search fa-fw "></span>
                            </div>
                            <input type="search" class="form-control" id="search" name="search" minlength="1"
                                maxlength="50" placeholder="{{ trans('field.search') }}" wire:model.lazy="search"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="button" class="btn btn-warning" wire:click="resetFilter"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetFilter">
                                <span class="fas fa-eraser fa-fw"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                            <span wire:loading wire:target="resetFilter" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl">
                        <label class="form-label" for="district_id">
                            {{ trans('field.district_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="district_id" name="district_id"
                                wire:key="district_id" wire:model.lazy="district_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('page.district') }}</option>
                                @foreach ($this->districts() as $district)
                                    <option value="{{ $district->id }}"
                                        {{ $district->id == $district_id ? 'selected' : '' }}
                                        wire:key="district-{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl">
                        <label class="form-label" for="area_id">
                            {{ trans('field.area_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-archway fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="area_id" name="area_id" wire:key="area_id"
                                wire:model.lazy="area_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('page.area') }}</option>
                                @foreach ($this->areas() as $area)
                                    <option value="{{ $area->id }}" {{ $area->id == $area_id ? 'selected' : '' }}
                                        wire:key="area-{{ $area->id }}">
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl">
                        <label class="form-label" for="bedroom">
                            {{ trans('field.bedroom') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-archway fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="bedroom" name="bedroom" wire:key="bedroom"
                                wire:model.lazy="bedroom" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('index.bedroom') }}</option>
                                @foreach ($this->propertyBedrooms() as $propertyBedroom)
                                    <option value="{{ $propertyBedroom->value }}"
                                        {{ $propertyBedroom->value == $bedroom ? 'selected' : '' }}
                                        wire:key="property-bedroom-{{ $propertyBedroom->value }}">
                                        {{ $propertyBedroom->description() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl">
                        <label class="form-label" for="rental_type">
                            {{ trans('field.rental_type') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-archway fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="rental_type" name="rental_type"
                                wire:key="rental_type" wire:model.lazy="rental_type" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('index.rental_type') }}
                                </option>
                                @foreach ($this->propertyBedrooms() as $propertyBedroom)
                                    <option value="{{ $propertyBedroom->value }}"
                                        {{ $propertyBedroom->value == $rental_type ? 'selected' : '' }}
                                        wire:key="property-rental-type-{{ $propertyBedroom->value }}">
                                        {{ $propertyBedroom->description() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-sm-3 col-lg-auto">
                        <label class="form-label" for="start_date">
                            {{ trans('field.start_date') }}
                        </label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                min="2026-01-01" max="2099-12-12" wire:key="start_date" wire:model.lazy="start_date"
                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                    </div>

                    <div class="col-6 col-sm-3 col-lg-auto">
                        <label class="form-label" for="end_date">
                            {{ trans('field.end_date') }}
                        </label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                min="2026-01-01" max="2099-12-12" wire:key="end_date" wire:model.lazy="end_date"
                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-header text-bg-primary">
            <span class="fas fa-table fa-fw"></span>
            {{ trans('index.data') }} @yield('title')
        </div>

        <div class="card-body">
            <div class="row g-3">
                @can('contact.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.contact.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('contact.export')
                    <div class="col-auto">
                        <button type="button" class="btn btn-success w-100" wire:click="export"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="export">
                                <span class="fas fa-file-excel fa-fw"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                            <span wire:loading wire:target="export" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                        </button>
                    </div>
                @endcan
            </div>

            <hr />

            <div class="table-responsive border-bottom mb-3">
                <table
                    class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th width="1%">{{ trans('field.code') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th>{{ trans('field.email') }}</th>
                            <th>{{ trans('field.phone') }}</th>
                            <th width="1%">{{ trans('field.message') }}</th>
                            <th width="1%">{{ trans('page.property') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->contacts() as $contact)
                            <tr wire:key="contact-{{ $contact->id }}">
                                <td class="text-center">
                                    {{ ($this->contacts()->currentPage() - 1) * $this->contacts()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.contact.detail', ['contact' => $contact]) }}"
                                        wire:navigate>
                                        {{ $contact->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="{{ config('constants.ghl.app_url') }}/v2/location/{{ config('constants.ghl.location_id') }}/contacts/detail/{{ $contact->code }}"
                                        target="_blank">
                                        {{ $contact->code }}
                                    </a>
                                </td>
                                <td>{{ $contact->name }}</td>
                                <td>
                                    <a draggable="false" href="mailto:{{ $contact->email }}">
                                        {{ $contact->email }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="https://api.whatsapp.com/send/?phone={{ $contact->phone }}"
                                        target="_blank">
                                        {{ $contact->phone }}
                                    </a>
                                </td>
                                <td>
                                    @if ($contact->message)
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#contact-{{ $contact->id }}">
                                            <span class="fas fa-folder-open fa-fw"></span>
                                            {{ trans('index.open') }}
                                        </button>

                                        <div class="modal fade" id="contact-{{ $contact->id }}" tabindex="-1">
                                            <div
                                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">
                                                            <span class="fas fa-file-lines fa-fw"></span>
                                                            {{ trans('index.contact') }} {{ trans('index.message') }}
                                                        </h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-pre-wrap">{!! $contact->message !!}</div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary w-100"
                                                            data-bs-dismiss="modal">
                                                            <span class="fas fa-folder-closed fa-fw"></span>
                                                            {{ trans('index.close') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($contact->properties as $property)
                                        <div wire:key="property-{{ $property->id }}">
                                            <a draggable="false"
                                                href="{{ route('cms.property.detail', ['property' => $property]) }}"
                                                wire:navigate>
                                                {{ $loop->iteration }}.
                                                {{ $property->code }} - {{ $property->name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $contact->created_at->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('contact.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.contact.detail', ['contact' => $contact]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('contact.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.contact.edit', ['contact' => $contact]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('contact.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $contact->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $contact->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $contact->id }})"
                                                    class="w-100">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="100%">
                                    {{ trans('message.no_data_available') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $this->contacts()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#district_id").on("change", function() {
            @this.set("district_id", $(this).val())
        })

        $("#area_id").on("change", function() {
            @this.set("area_id", $(this).val())
        })

        $("#bedroom").on("change", function() {
            @this.set("bedroom", $(this).val())
        })

        $("#rental_type").on("change", function() {
            @this.set("rental_type", $(this).val())
        })
    </script>
@endscript
