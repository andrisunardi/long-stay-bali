<?php

namespace App\Livewire\Forms\CMS\Property;

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyCurrency;
use App\Enums\Property\PropertyElectricity;
use App\Enums\Property\PropertyLandContour;
use App\Enums\Property\PropertyLandTitle;
use App\Enums\Property\PropertyLeaseExtensionAvailable;
use App\Enums\Property\PropertyListingType;
use App\Enums\Property\PropertyLivingStyle;
use App\Enums\Property\PropertyOperationalRisk;
use App\Enums\Property\PropertyOrientation;
use App\Enums\Property\PropertyOwnerPriceFlexibility;
use App\Enums\Property\PropertyOwnershipType;
use App\Enums\Property\PropertyPBGStatus;
use App\Enums\Property\PropertyPowerBackup;
use App\Enums\Property\PropertyRentalType;
use App\Enums\Property\PropertyRoadAccess;
use App\Enums\Property\PropertySLFStatus;
use App\Enums\Property\PropertyStatus;
use App\Enums\Property\PropertyTargetProfile;
use App\Enums\Property\PropertyType;
use App\Enums\Property\PropertyWaterSource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class PropertyEditForm extends Form
{
    public Property $property;

    public string $code = '';

    #[Validate('required|string|min:1|max:100')]
    public string $name = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public ?string $description = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public ?string $description_id = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public ?string $description_zh = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public ?string $description_fr = '';

    #[Validate('nullable|integer|exists:users,id')]
    public ?int $user_id = null;

    #[Validate('nullable|date|date_format:Y-m-d|before_or_equal:2999-12-31')]
    public ?string $availability_date = '';

    #[Validate('nullable|date|date_format:Y-m-d|before_or_equal:2999-12-31')]
    public ?string $visit_date = '';

    #[Validate('nullable|integer|digits:4|min:1901|max:2100')]
    public ?int $year_built = null;

    #[Validate('nullable|required_if:status,'.PropertyStatus::UnderConstruction->value.','.PropertyStatus::OffPlan->value.'|date|date_format:Y-m-d|after_or_equal:1901-01-01|before_or_equal:2999-12-31')]
    public ?string $completion_date = '';

    #[Validate(['required', 'integer', new Enum(PropertyBedroom::class)])]
    public int $bedroom = PropertyBedroom::OneBedroom->value;

    #[Validate('nullable|string|min:1|max:50')]
    public ?string $villa_name = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public ?string $google_maps_url = '';

    #[Validate('nullable|string')]
    public ?string $latitude = '';

    #[Validate('nullable|string')]
    public ?string $longitude = '';

    #[Validate('nullable|string|min:1|max:200')]
    public ?string $address = '';

    #[Validate('nullable|integer|exists:districts,id')]
    public ?int $district_id = null;

    #[Validate('nullable|integer|exists:areas,id')]
    public ?int $area_id = null;

    #[Validate('nullable|integer|min:0|max:9999999999')]
    public ?int $land_size = null;

    #[Validate('nullable|integer|min:0|max:9999999999')]
    public ?int $building_size = null;

    #[Validate('nullable|integer|min:0|max:255')]
    public ?int $number_of_floors = null;

    #[Validate('nullable|integer|min:0|max:9999999999')]
    public ?int $outdoor_area_size = null;

    #[Validate('nullable|integer|min:0|max:255')]
    public ?int $number_of_bathrooms = null;

    #[Validate('nullable|string|min:1|max:50')]
    public ?string $pool_size = '';

    #[Validate('nullable|boolean')]
    public bool $ensuite_bathrooms = false;

    #[Validate('nullable|boolean')]
    public bool $guest_toilet = false;

    #[Validate('nullable|boolean')]
    public bool $storage = false;

    #[Validate(['nullable', 'integer', new Enum(PropertyLivingStyle::class)])]
    public ?int $living_style = null;

    #[Validate('nullable|boolean')]
    public bool $full_legal_documentation = false;

    #[Validate('nullable|boolean')]
    public bool $signed_listing_agreement = false;

    #[Validate('nullable|boolean')]
    public bool $lease_agreement = false;

    #[Validate('nullable|boolean')]
    public bool $land_certificate = false;

    #[Validate('nullable|boolean')]
    public bool $owners_id = false;

    #[Validate('nullable|boolean')]
    public bool $imb = false;

    #[Validate('nullable|boolean')]
    public bool $pbg = false;

    #[Validate('nullable|boolean')]
    public bool $slf = false;

    #[Validate(['nullable', 'integer', new Enum(PropertyLandTitle::class)])]
    public ?int $land_title = null;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $zoning = '';

    #[Validate(['nullable', 'integer', new Enum(PropertyPBGStatus::class)])]
    public ?int $pbg_status = null;

    #[Validate(['nullable', 'integer', new Enum(PropertySLFStatus::class)])]
    public ?int $slf_status = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyRoadAccess::class)])]
    public ?int $road_access = null;

    #[Validate('nullable|string|min:1|max:100')]
    public string $road_access_width = '';

    #[Validate('nullable|boolean')]
    public bool $car_access = false;

    #[Validate('nullable|boolean')]
    public bool $fully_furnished = false;

    #[Validate(['nullable', 'integer', new Enum(PropertyRentalType::class)])]
    public ?int $rental_type = null;

    #[Validate('nullable|integer|min:0|max:9999999999')]
    public ?int $minimum_rental_duration_months = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyOwnerPriceFlexibility::class)])]
    public ?int $owner_price_flexibility = null;

    #[Validate('nullable|boolean')]
    public bool $price_coherent_with_upper = false;

    #[Validate('nullable|boolean')]
    public bool $not_directly_exposed_to_main_road = false;

    #[Validate('nullable|boolean')]
    public bool $no_festive_venue_nearby = false;

    #[Validate('nullable|boolean')]
    public bool $no_ongoing = false;

    #[Validate('nullable|boolean')]
    public bool $quiet_access_road = false;

    #[Validate(['nullable', 'integer', new Enum(PropertyOrientation::class)])]
    public ?int $orientation = null;

    #[Validate('nullable|string|min:0|max:65535')]
    public ?string $view = '';

    #[Validate('nullable|boolean')]
    public bool $living_area_has_natural_light = false;

    #[Validate('nullable|boolean')]
    public bool $bedroom_1_has_natural_light = false;

    #[Validate('nullable|boolean')]
    public bool $bedroom_2_has_natural_light = false;

    #[Validate('nullable|boolean')]
    public bool $noise_source_identified = false;

    #[Validate('nullable|integer|min:0|max:9999999999')]
    public ?int $internet_speedtest = null;

    #[Validate('nullable|image|file|mimes:jpg,jpeg,png,gif,webp|max:12288')]
    public ?TemporaryUploadedFile $internet_speedtest_image = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyPowerBackup::class)])]
    public ?int $power_backup = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyWaterSource::class)])]
    public ?int $water_source = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyElectricity::class)])]
    public ?int $electricity = null;

    #[Validate('nullable|boolean')]
    public bool $eligible_for_upper = false;

    #[Validate('nullable|boolean')]
    public bool $eligible_for_premium = false;

    #[Validate('nullable|boolean')]
    public bool $design_driven_property = false;

    #[Validate('nullable|string|min:0|max:65535')]
    public ?string $usability_limitations = '';

    #[Validate('nullable|boolean')]
    public bool $trade_off_identified = false;

    #[Validate('nullable|string|min:0|max:65535')]
    public ?string $trade_off_description = '';

    #[Validate([
        'target_profiles' => ['nullable', 'array'],
        'target_profiles.*' => ['integer', new Enum(PropertyTargetProfile::class)],
    ])]
    public array $target_profiles = [];

    #[Validate(['nullable', 'integer', new Enum(PropertyOperationalRisk::class)])]
    public ?int $operational_risk = null;

    #[Validate('nullable|string|min:0|max:65535')]
    public ?string $operational_risk_comment = '';

    #[Validate('required|integer|min:0|max:100000000000')]
    public ?int $monthly_price = 0;

    #[Validate('required|integer|min:0|max:100000000000')]
    public ?int $yearly_price = 0;

    #[Validate('nullable|array')]
    public array $monthly_inclusions = [
        'housekeeper' => false,
        'housekeeper_frequency_per_week' => null,
        'gardener' => false,
        'pool_guy' => false,
        'internet' => false,
        'garbage' => false,
        'banjar' => false,
        'security' => false,
        'electricity' => false,
        'others' => null,
    ];

    #[Validate('nullable|array')]
    public array $yearly_inclusions = [
        'housekeeper' => false,
        'housekeeper_frequency_per_week' => null,
        'gardener' => false,
        'pool_guy' => false,
        'internet' => false,
        'garbage' => false,
        'banjar' => false,
        'security' => false,
        'electricity' => false,
        'others' => null,
    ];

    #[Validate('nullable|integer|exists:contacts,id')]
    public ?int $owner_id = null;

    #[Validate('nullable|integer|exists:contacts,id')]
    public ?int $owner_representative_id = null;

    #[Validate(['required', 'integer', new Enum(PropertyListingType::class)])]
    public ?int $listing_type = null;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $reference = '';

    #[Validate('required|integer|min:0|max:100000000000')]
    public ?int $sale_price = 0;

    #[Validate(['nullable', 'integer', new Enum(PropertyCurrency::class)])]
    public ?int $currency = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyOwnershipType::class)])]
    public ?int $ownership_type = null;

    #[Validate('nullable|required_if:ownership_type,'.PropertyOwnershipType::Leasehold->value.'|date|date_format:Y-m-d|after_or_equal:1901-01-01|before_or_equal:2999-12-31')]
    public ?string $lease_expiry_date = '';

    #[Validate(['nullable', 'required_if:ownership_type,'.PropertyOwnershipType::Leasehold->value, 'integer', new Enum(PropertyLeaseExtensionAvailable::class)])]
    public ?int $lease_extension_available = null;

    #[Validate('nullable|required_if:ownership_type,'.PropertyOwnershipType::Leasehold->value.'|string|min:1|max:65535')]
    public ?string $lease_extension_terms_or_price = '';

    #[Validate('nullable|boolean')]
    public bool $payment_plan_available = false;

    #[Validate('nullable|required_if:payment_plan_available,1|string|min:1|max:65535')]
    public ?string $payment_plan_details = '';

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $developer_name = '';

    #[Validate('required|integer|min:0|max:100000000000')]
    public ?int $price_per_are = 0;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $land_size_in_ares = '';

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $road_frontage = '';

    #[Validate(['nullable', 'integer', new Enum(PropertyLandContour::class)])]
    public ?int $land_contour = null;

    #[Validate('nullable|boolean')]
    public bool $subdivision_possible = false;

    #[Validate('nullable|string|min:1|max:100')]
    public ?string $minimum_purchase_size = '';

    #[Validate(['nullable', 'integer', new Enum(PropertyType::class)])]
    public int $type = PropertyType::Villa->value;

    #[Validate(['nullable', 'integer', new Enum(PropertyStatus::class)])]
    public int $status = PropertyStatus::Pending->value;

    // #[Validate('nullable|image|file|mimes:jpg,jpeg,png,gif,webp|max:12288')]
    // public ?TemporaryUploadedFile $image = null;

    #[Validate(['nullable', 'array', 'min:0'])]
    public array $images = [];

    public function set(Property $property): void
    {
        $this->property = $property;
        $this->code = $property->code;
        $this->name = $property->name;
        $this->description = $property->description;
        $this->description_id = $property->description_id;
        $this->description_zh = $property->description_zh;
        $this->description_fr = $property->description_fr;
        $this->trade_off_description = $property->trade_off_description;
        $this->user_id = $property->user_id;
        $this->availability_date = $property->availability_date?->toDateString();
        $this->visit_date = $property->visit_date?->toDateString();
        $this->year_built = $property->year_built;
        $this->completion_date = $property->completion_date?->toDateString();
        $this->bedroom = $property->bedroom?->value;

        $this->villa_name = $property->villa_name;
        $this->google_maps_url = $property->google_maps_url;
        $this->latitude = $property->latitude;
        $this->longitude = $property->longitude;
        $this->address = $property->address;
        $this->district_id = $property->district_id;
        $this->area_id = $property->area_id;

        $this->land_size = $property->land_size;
        $this->building_size = $property->building_size;
        $this->number_of_floors = $property->number_of_floors;
        $this->outdoor_area_size = $property->outdoor_area_size;
        $this->pool_size = $property->pool_size;

        $this->number_of_bathrooms = $property->number_of_bathrooms;
        $this->ensuite_bathrooms = $property->ensuite_bathrooms;
        $this->guest_toilet = $property->guest_toilet;
        $this->storage = $property->storage;
        $this->living_style = $property->living_style?->value;

        $this->full_legal_documentation = $property->full_legal_documentation;
        $this->signed_listing_agreement = $property->signed_listing_agreement;
        $this->lease_agreement = $property->lease_agreement;
        $this->land_certificate = $property->land_certificate;
        $this->owners_id = $property->owners_id;
        $this->imb = $property->imb;
        $this->pbg = $property->pbg;
        $this->slf = $property->slf;
        $this->land_title = $property->land_title?->value;
        $this->zoning = $property->zoning;
        $this->pbg_status = $property->pbg_status?->value;
        $this->slf_status = $property->slf_status?->value;
        $this->road_access = $property->road_access?->value;
        $this->road_access_width = $property->road_access_width;
        $this->car_access = $property->car_access;

        $this->fully_furnished = $property->fully_furnished;
        $this->rental_type = $property->rental_type?->value;
        $this->minimum_rental_duration_months = $property->minimum_rental_duration_months;
        $this->owner_price_flexibility = $property->owner_price_flexibility?->value;
        $this->price_coherent_with_upper = $property->price_coherent_with_upper;
        $this->not_directly_exposed_to_main_road = $property->not_directly_exposed_to_main_road;
        $this->no_festive_venue_nearby = $property->no_festive_venue_nearby;
        $this->no_ongoing = $property->no_ongoing;
        $this->quiet_access_road = $property->quiet_access_road;
        $this->orientation = $property->orientation?->value;
        $this->view = $property->view;

        $this->living_area_has_natural_light = $property->living_area_has_natural_light;
        $this->bedroom_1_has_natural_light = $property->bedroom_1_has_natural_light;
        $this->bedroom_2_has_natural_light = $property->bedroom_2_has_natural_light;
        $this->noise_source_identified = $property->noise_source_identified;

        $this->internet_speedtest = $property->internet_speedtest;
        $this->power_backup = $property->power_backup?->value;
        $this->water_source = $property->water_source?->value;
        $this->electricity = $property->electricity?->value;

        $this->eligible_for_upper = $property->eligible_for_upper;
        $this->eligible_for_premium = $property->eligible_for_premium;

        $this->design_driven_property = $property->design_driven_property;
        $this->usability_limitations = $property->usability_limitations;

        $this->trade_off_identified = $property->trade_off_identified;
        $this->trade_off_description = $property->trade_off_description;
        $this->target_profiles = $property->target_profiles ?? [];

        $this->operational_risk = $property->operational_risk?->value;
        $this->operational_risk_comment = $property->operational_risk_comment;

        $this->monthly_price = $property->monthly_price;
        $this->yearly_price = $property->yearly_price;

        $this->monthly_inclusions = $property->monthly_inclusions ?? [
            'housekeeper' => false,
            'housekeeper_frequency_per_week' => null,
            'gardener' => false,
            'pool_guy' => false,
            'internet' => false,
            'garbage' => false,
            'banjar' => false,
            'security' => false,
            'electricity' => false,
            'others' => null,
        ];

        $this->yearly_inclusions = $property->yearly_inclusions ?? [
            'housekeeper' => false,
            'housekeeper_frequency_per_week' => null,
            'gardener' => false,
            'pool_guy' => false,
            'internet' => false,
            'garbage' => false,
            'banjar' => false,
            'security' => false,
            'electricity' => false,
            'others' => null,
        ];

        $this->owner_id = $property->owner?->id;
        $this->owner_representative_id = $property->ownerRepresentative?->id;

        $this->listing_type = $property->listing_type?->value;
        $this->reference = $property->reference;

        $this->sale_price = $property->sale_price;
        $this->currency = $property->currency?->value;
        $this->ownership_type = $property->ownership_type?->value;
        $this->lease_expiry_date = $property->lease_expiry_date?->toDateString();
        $this->lease_extension_available = $property->lease_extension_available?->value;
        $this->lease_extension_terms_or_price = $property->lease_extension_terms_or_price;
        $this->payment_plan_available = $property->payment_plan_available;
        $this->payment_plan_details = $property->payment_plan_details;
        $this->developer_name = $property->developer_name;

        $this->price_per_are = $property->price_per_are;
        $this->land_size_in_ares = $property->land_size_in_ares;
        $this->road_frontage = $property->road_frontage;
        $this->land_contour = $property->land_contour?->value;
        $this->subdivision_possible = $property->subdivision_possible;
        $this->minimum_purchase_size = $property->minimum_purchase_size;

        $this->type = $property->type?->value;
        $this->status = $property->status?->value;

        $this->images = $property->images ? $property->images->sortBy('position')
            ->map(function ($propertyImage) {
                $headers = array_change_key_case(get_headers($propertyImage->image_url, true), CASE_LOWER);
                $getimagesize = getimagesize($propertyImage->image_url);

                return [
                    'id' => $propertyImage->google_file_id ?: $propertyImage->id,
                    'name' => $propertyImage->name,
                    'type' => 'url',
                    'thumbnail' => $propertyImage->image_url,
                    'size' => $headers['content-length'] ?? 0,
                    'resolution' => [
                        'width' => $getimagesize[0] ?? null,
                        'height' => $getimagesize[1] ?? null,
                    ],
                    'mime' => $getimagesize['mime'] ?? null,
                ];
            })
            ->values()
            ->toArray() : [];
    }

    public function rules(): array
    {
        return [
            'code' => "required|string|min:1|max:10|unique:properties,code,{$this->property->id}",
        ];
    }

    public function submit(Property $property): Property
    {
        return (new PropertyService)->update(property: $property, data: $this->validate());
    }
}
