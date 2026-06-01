<h4 class="mb-3">{{ trans('property.what_this_home_offers') }}</h4>

<div class="row g-3">
    @if (in_array($property->rental_type, [PropertyRentalType::Monthly, PropertyRentalType::Both]))
        <div class="col-sm-6">
            <h6>{{ trans('property.monthly') }}</h6>
            <div class="d-grid gap-2">
                @if ($monthlyHasInclusions)
                    @if ($property->monthly_inclusions['housekeeper'] ?? false)
                        <div>
                            <span class="fas fa-broom fa-fw"></span>
                            {{ trans('property.housekeeper') }}
                            {{-- {{ $property->monthly_inclusions['housekeeper_frequency_per_week'] }}
                            /
                            {{ trans('property.weeks') }} --}}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['gardener'] ?? false)
                        <div>
                            <span class="fas fa-seedling fa-fw"></span>
                            {{ trans('property.gardener') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['pool_guy'] ?? false)
                        <div>
                            <span class="fas fa-person-swimming fa-fw"></span>
                            {{ trans('property.pool_guy') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['internet'] ?? false)
                        <div>
                            <span class="fas fa-wifi fa-fw"></span>
                            {{ trans('property.internet') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['garbage'] ?? false)
                        <div>
                            <span class="fas fa-trash fa-fw"></span>
                            {{ trans('property.garbage') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['banjar'] ?? false)
                        <div>
                            <span class="fas fa-bank fa-fw"></span>
                            {{ trans('property.banjar') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['security'] ?? false)
                        <div>
                            <span class="fas fa-shield fa-fw"></span>
                            {{ trans('property.security') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['electricity'] ?? false)
                        <div>
                            <span class="fas fa-bold-lighting fa-fw"></span>
                            {{ trans('property.electricity') }}
                        </div>
                    @endif

                    @if ($property->monthly_inclusions['others'] ?? false)
                        <div class="bg-secondary-subtle p-3 rounded">
                            {{ $property->monthly_inclusions['others'] }}
                        </div>
                    @endif
                @else
                    <div>
                        <span class="fas fa-building fa-fw"></span>
                        {{ trans('property.property_only') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if (in_array($property->rental_type, [PropertyRentalType::Yearly, PropertyRentalType::Both]))
        <div class="col-sm-6">
            <h6>{{ trans('property.yearly') }}</h6>
            <div class="d-grid gap-2">
                @if ($yearlyHasInclusions)
                    @if ($property->yearly_inclusions['housekeeper'] ?? false)
                        <div>
                            <span class="fas fa-broom fa-fw"></span>
                            {{ trans('property.housekeeper') }}
                            {{-- {{ $property->yearly_inclusions['housekeeper_frequency_per_week'] }}
                            /
                            {{ trans('property.weeks') }} --}}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['gardener'] ?? false)
                        <div>
                            <span class="fas fa-seedling fa-fw"></span>
                            {{ trans('property.gardener') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['pool_guy'] ?? false)
                        <div>
                            <span class="fas fa-person-swimming fa-fw"></span>
                            {{ trans('property.pool_guy') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['internet'] ?? false)
                        <div>
                            <span class="fas fa-wifi fa-fw"></span>
                            {{ trans('property.internet') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['garbage'] ?? false)
                        <div>
                            <span class="fas fa-trash fa-fw"></span>
                            {{ trans('property.garbage') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['banjar'] ?? false)
                        <div>
                            <span class="fas fa-bank fa-fw"></span>
                            {{ trans('property.banjar') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['security'] ?? false)
                        <div>
                            <span class="fas fa-shield fa-fw"></span>
                            {{ trans('property.security') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['electricity'] ?? false)
                        <div>
                            <span class="fas fa-bold-lighting fa-fw"></span>
                            {{ trans('property.electricity') }}
                        </div>
                    @endif

                    @if ($property->yearly_inclusions['others'] ?? false)
                        <div class="bg-secondary-subtle p-3 rounded">
                            {{ $property->yearly_inclusions['others'] }}
                        </div>
                    @endif
                @else
                    <div>
                        <span class="fas fa-building fa-fw"></span>
                        {{ trans('property.property_only') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
