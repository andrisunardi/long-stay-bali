@props([
    'property' => null,
    'form',
    'tab',
    'type',
])

@if ($tab == PropertyTab::PropertyIndentity->value)
    <x-cms.property.property-identity :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::Location->value)
    <x-cms.property.location :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::SizeAndSurfaces->value)
    <x-cms.property.size-and-surfaces :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::BathroomsAndLayout->value)
    <x-cms.property.bathrooms-and-layout :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::LegalAndBasicEligibility->value)
    <x-cms.property.legal-and-basic-eligibility :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::EnvironmentAndTranquility->value)
    <x-cms.property.environment-and-tranquility :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::LightAndAcoustics->value)
    <x-cms.property.light-and-acoustics :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::UtilitiesAndTechnical->value)
    <x-cms.property.utilities-and-technical :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::DesignLedOrInstagrammable->value)
    <x-cms.property.design-led-or-instagrammable :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::TradeOffAndTargetProfile->value)
    <x-cms.property.trade-off-and-target-profile :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::PriceAndInclusions->value)
    <x-cms.property.price-and-inclusions :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::OwnerAndContact->value)
    <x-cms.property.owner-and-contact :property="$property" :form="$form" :type="$type" />
@endif

@if ($tab == PropertyTab::Images->value)
    <livewire:cms.property.images :property="$property" :form="$form" :selected="$form->images ?? []" />
@endif

@if ($tab == PropertyTab::SaleInformation->value)
    <x-cms.property.sale-information :property="$property" :form="$form" :type="$type" />
@endif
