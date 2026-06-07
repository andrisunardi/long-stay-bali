@props([
    'area' => null,
    'districts' => [],
    'areas' => [],
    'listDistricts' => [],
    'bedrooms' => [],
    'livingStyle' => null,
    'rentalType' => null,
    'prices' => [],
    'priceMin' => null,
    'priceMax' => null,
])

<div class="modal fade" id="modal-search" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    {{ trans('home.search.title') }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-3">
                    {{-- prettier-ignore --}}
                    <x-search.area
                    :area="$area"
                    :districts="$districts"
                    :areas="$areas"
                    :list-districts="$listDistricts"
                    />

                    <div wire:ignore>
                        <label class="form-label">
                            <span class="fas fa-calendar fa-fw"></span>
                            {{ trans('validation.attributes.when') }}
                        </label>
                        <input type="text" id="daterange" class="form-control" autocomplete="off" readonly>
                    </div>

                    <x-search.bedrooms :bedrooms="$bedrooms" />

                    <x-search.living-style :living-style="$livingStyle" />

                    <div>
                        <label class="form-label">{{ trans('property.rental_type') }}</label>
                        <x-search.rental-type :rental-type="$rentalType" />
                    </div>

                    @if ($rentalType)
                        {{-- prettier-ignore --}}
                        <x-search.price
                        :rental-type="$rentalType"
                        :prices="$prices"
                        :price-min="$priceMin"
                        :price-max="$priceMax"
                        />
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                {{-- prettier-ignore --}}
                <x-search.button
                :districts="$districts"
                :areas="$areas"
                :bedrooms="$bedrooms"
                :living-style="$livingStyle"
                :prices="$prices"
                />
            </div>
        </div>
    </div>
</div>
