<?php

use App\Livewire\Component;
use App\Models\Property;
use App\Services\PropertyService;
use Livewire\Attributes\Title;

new #[Title('Detail | Property')] class extends Component {
    public Property $property;

    public function mount(Property $property): void
    {
        $this->property = $property;
    }

    public function delete(): void
    {
        $service = new PropertyService();
        $service->delete(property: $this->property);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.property') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.property.index'), navigate: true);
    }
};
?>

@section('title', trans('page.property'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.property.index') }}" wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>

                @can('property.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.property.edit', ['property' => $property]) }}" wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('property.delete')
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger w-100" wire:click="delete"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">
                                <span class="fas fa-trash fa-fw"></span>
                                {{ trans('index.delete') }}
                            </span>
                            <span wire:loading wire:target="delete" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.delete') }}
                            </span>
                        </button>
                    </div>
                @endcan
            </div>

            <hr />

            <div class="d-grid gap-3">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->name }}

                        @if (in_array($property->status, [PropertyStatus::AcceptUpper, PropertyStatus::AcceptPremium]))
                            <a draggable="false" href="{{ route('property.detail', ['slug' => $property->slug]) }}"
                                target="_blank">
                                <span class="fas fa-external-link fa-fw"></span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $property->description !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $property->description_id !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description_fr') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {!! $property->description_fr !!}
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">Image</div>
                    </div>
                    <div class="col-sm-7 col-md-6 col-lg-5 col-xl-4">
                        @if ($property->image_path)
                            <a draggable="false" href="{{ $property->image }}" target="_blank">
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 rounded mt-2" src="{{ $property->image }}"
                                    alt="{{ trans('page.property') }} - {{ $property->id }}"
                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                            </a>
                        @endif
                    </div>
                </div> --}}

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.property_identity') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.internal_property_code') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->code }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.availability_date') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->availability_date?->isoFormat('DD MMMM YYYY') ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.agent_name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->user->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.date_of_visit') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->visit_date?->isoFormat('DD MMMM YYYY') ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.location') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.gps_coordinates') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->latitude ?? '-' }} / {{ $property->longitude ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.address') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->address ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.district_or_area') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->district->name ?? '-' }}, {{ $property->area->name ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.size_and_surfaces') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.land_size') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->land_size ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.building_size') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->building_size ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.number_of_floors') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->number_of_floors ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.outdoor_area_size') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->outdoor_area_size ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.pool_size') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->pool_size ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.bathrooms_and_layout') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.number_of_bathrooms') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->number_of_bathrooms ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.ensuite_bathrooms') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->ensuite_bathrooms ? 'success' : 'danger' }}">
                            {{ $property->ensuite_bathrooms ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.guest_toilet') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ $property->guest_toilet ? 'success' : 'danger' }}">
                            {{ $property->guest_toilet ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.storage_or_staff_area') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ $property->storage ? 'success' : 'danger' }}">
                            {{ $property->storage ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.living_style') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->living_style?->name ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.legal_and_basic_eligibility') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.full_legal_documentation_available') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->full_legal_documentation ? 'success' : 'danger' }}">
                            {{ $property->full_legal_documentation ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.signed_listing_agreement') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ Str::successDanger($property->signed_listing_agreement) }}">
                            {{ Str::yesNo($property->signed_listing_agreement) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.lease_agreement') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($property->lease_agreement) }}">
                            {{ Str::yesNo($property->lease_agreement) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.land_certificate') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ Str::successDanger($property->land_certificate) }}">
                            {{ Str::yesNo($property->land_certificate) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.owners_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($property->owners_id) }}">
                            {{ Str::yesNo($property->owners_id) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.imb') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($property->imb) }}">
                            {{ Str::yesNo($property->imb) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.pbg') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($property->pbg) }}">
                            {{ Str::yesNo($property->pbg) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.slf') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($property->slf) }}">
                            {{ Str::yesNo($property->slf) }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.fully_furnished') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->fully_furnished ? 'success' : 'danger' }}">
                            {{ $property->fully_furnished ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.rental_type_accepted') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->rental_type?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.minimum_rental_duration') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->rental_type?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.owner_price_flexibility') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->owner_price_flexibility?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">
                            {{ trans('property.price_coherent_with_upper_or_premium_positioning') }}
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->price_coherent_with_upper ? 'success' : 'danger' }}">
                            {{ $property->price_coherent_with_upper ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.environment_and_tranquility') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.not_directly_exposed_to_main_road') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->not_directly_exposed_to_main_road ? 'success' : 'danger' }}">
                            {{ $property->not_directly_exposed_to_main_road ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.no_festive_venue_nearby') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->no_festive_venue_nearby ? 'success' : 'danger' }}">
                            {{ $property->no_festive_venue_nearby ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.no_ongoing_or_imminent_construction') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ $property->no_ongoing ? 'success' : 'danger' }}">
                            {{ $property->no_ongoing ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.quiet_access_road_or_gang') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->quiet_access_road ? 'success' : 'danger' }}">
                            {{ $property->quiet_access_road ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.orientation') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->orientation?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.view') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->view ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.light_and_acoustics') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.living_area_has_natural_light') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->living_area_has_natural_light ? 'success' : 'danger' }}">
                            {{ $property->living_area_has_natural_light ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.bedroom_1_has_natural_light') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->bedroom_1_has_natural_light ? 'success' : 'danger' }}">
                            {{ $property->bedroom_1_has_natural_light ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.bedroom_2_has_natural_light') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->bedroom_2_has_natural_light ? 'success' : 'danger' }}">
                            {{ $property->bedroom_2_has_natural_light ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.noise_source_identified') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->noise_source_identifieds ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.view') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->view ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.utilities_and_technical') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.internet_speedtest') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->internet_speedtest ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">Internet Speedtest Image</div>
                    </div>
                    <div class="col-sm-7 col-md-6 col-lg-5 col-xl-4">
                        {{-- @if ($property->internet_speedtest_image_path)
                            <a draggable="false" href="{{ $property->internet_speedtest_image }}" target="_blank">
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 rounded mt-2"
                                    src="{{ $property->internet_speedtest_image }}"
                                    alt="{{ trans('page.property') }} - {{ $property->id }}"
                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                            </a>
                        @endif --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.power_backup') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->power_backup?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.water_source') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->water_source?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.electricity') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->electricity?->description() ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.category_assessment') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.eligible_for_upper') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->eligible_for_upper ? 'success' : 'danger' }}">
                            {{ $property->eligible_for_upper ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.eligible_for_premium') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->eligible_for_premium ? 'success' : 'danger' }}">
                            {{ $property->eligible_for_premium ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.design_led_or_instagrammable') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.design_driven_property') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->design_driven_property ? 'success' : 'danger' }}">
                            {{ $property->design_driven_property ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.usability_limitations_identified') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->usability_limitations ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.trade_off_and_target_profile') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.trade_off_identified') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span
                            class="badge rounded-pill text-bg-{{ $property->trade_off_identified ? 'success' : 'danger' }}">
                            {{ $property->trade_off_identified ? trans('index.yes') : trans('index.no') }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.if_yes_describe_briefly') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->trade_off_description ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.target_profiles') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @foreach ($property->target_profiles ?? [] as $targetProfile)
                            <span class="badge rounded-pill text-bg-primary">
                                {{ PropertyTargetProfile::From($targetProfile)->description() }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.operational_risk') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.operational_risk_level') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->operational_risk?->description() ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.comments_if_medium_or_high') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->operational_risk_comment ?? '-' }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.price_and_inclusions') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.monthly_price') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ Str::idr($property->monthly_price) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.yearly_price') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ Str::idr($property->yearly_price) }}
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.owner_and_contact') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.owner') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($property->owner)
                            <a draggable="false" class="fw-bold"
                                href="{{ route('cms.contact.detail', ['contact' => $property->owner]) }}"
                                wire:navigate>
                                {{ $property->owner->name }} - {{ $property->owner->phone }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.owner_representative') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($property->ownerRepresentative)
                            <a draggable="false"
                                href="{{ route('cms.contact.detail', ['contact' => $property->ownerRepresentative]) }}"
                                wire:navigate>
                                {{ $property->ownerRepresentative->name }} -
                                {{ $property->ownerRepresentative->phone }}
                            </a>
                        @endif
                    </div>
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.images') }}
                </h5>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                    @foreach ($property->images as $propertyImage)
                        <div class="col" wire:key="property-image-{{ $propertyImage->id }}">
                            <div class="card h-100">
                                <div class="ratio ratio-1x1">
                                    <a draggable="false" href="{{ $propertyImage->image_url }}" target="_blank">
                                        <img draggable="false" loading="lazy" decoding="async"
                                            class="img-fluid w-100 h-100 object-fit-cover"
                                            src="{{ $propertyImage->image_url }}">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="text-truncate">{{ $propertyImage->name }}</div>
                                    <div class="small">{{ $propertyImage->position }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <br />

                <h5 class="fw-bold text-uppercase border-bottom pb-3">
                    {{ trans('property.final_decision') }}
                </h5>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('property.status') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <span class="badge rounded-pill text-bg-{{ $property->status->color() }}">
                            {{ $property->status->description() }}
                        </span>
                    </div>
                </div>

                <br />

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->createdBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $property->updatedBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($property->created_at)
                            {{ $property->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $property->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($property->updated_at)
                            {{ $property->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $property->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('property.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.property.edit', ['property' => $property]) }}" wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('property.delete')
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger w-100" wire:click="delete"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">
                                <span class="fas fa-trash fa-fw"></span>
                                {{ trans('index.delete') }}
                            </span>
                            <span wire:loading wire:target="delete" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.delete') }}
                            </span>
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <livewire:activity-log :model="$property" />
</div>
