<?php

namespace App\Livewire\Forms\CMS\Property;

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyElectricity;
use App\Enums\Property\PropertyLivingStyle;
use App\Enums\Property\PropertyOperationalRisk;
use App\Enums\Property\PropertyOrientation;
use App\Enums\Property\PropertyOwnerPriceFlexibility;
use App\Enums\Property\PropertyPowerBackup;
use App\Enums\Property\PropertyRentalType;
use App\Enums\Property\PropertyStatus;
use App\Enums\Property\PropertyTargetProfile;
use App\Enums\Property\PropertyWaterSource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class PropertyAddForm extends Form
{
    #[Validate('required|string|min:1|max:10|unique:properties,code')]
    public string $code = '';

    #[Validate('required|string|min:1|max:50')]
    public string $name = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $description = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $description_id = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $description_fr = '';

    #[Validate('nullable|integer|exists:users,id')]
    public ?int $user_id = null;

    #[Validate('nullable|date|date_format:Y-m-d|after_or_equal:today|before_or_equal:2999-12-31')]
    public string $availability_date = '';

    #[Validate('nullable|date|date_format:Y-m-d|after_or_equal:today|before_or_equal:2999-12-31')]
    public string $visit_date = '';

    #[Validate(['required', 'integer', new Enum(PropertyBedroom::class)])]
    public int $bedroom = PropertyBedroom::OneBedroom->value;

    #[Validate('nullable|string|min:1|max:50')]
    public string $villa_name = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $google_maps_url = '';

    #[Validate('nullable|string')]
    public string $latitude = '';

    #[Validate('nullable|string')]
    public string $longitude = '';

    #[Validate('nullable|string|min:1|max:200')]
    public string $address = '';

    #[Validate('nullable|integer|exists:districts,id')]
    public ?int $district_id = null;

    #[Validate('nullable|integer|exists:areas,id')]
    public ?int $area_id = null;

    #[Validate('nullable|integer|min:1|max:9999999999')]
    public ?int $land_size = null;

    #[Validate('nullable|integer|min:1|max:9999999999')]
    public ?int $building_size = null;

    #[Validate('nullable|integer|min:1|max:255')]
    public ?int $number_of_floors = null;

    #[Validate('nullable|integer|min:1|max:9999999999')]
    public ?int $outdoor_area_size = null;

    #[Validate('nullable|integer|min:1|max:255')]
    public ?int $number_of_bathrooms = null;

    #[Validate('nullable|string|min:1|max:50')]
    public string $pool_size = '';

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

    #[Validate('nullable|boolean')]
    public bool $fully_furnished = false;

    #[Validate(['nullable', 'integer', new Enum(PropertyRentalType::class)])]
    public ?int $rental_type = null;

    #[Validate('nullable|integer|min:1|max:9999999999')]
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

    #[Validate('nullable|string|min:1|max:65535')]
    public string $view = '';

    #[Validate('nullable|boolean')]
    public bool $living_area_has_natural_light = false;

    #[Validate('nullable|boolean')]
    public bool $bedroom_1_has_natural_light = false;

    #[Validate('nullable|boolean')]
    public bool $bedroom_2_has_natural_light = false;

    #[Validate('nullable|string|min:1|max:65535')]
    public string $noise_source_identified = '';

    #[Validate('nullable|integer|min:1|max:9999999999')]
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

    #[Validate('nullable|string|min:1|max:65535')]
    public string $usability_limitations = '';

    #[Validate('nullable|boolean')]
    public bool $trade_off_identified = false;

    #[Validate('nullable|string|min:1|max:65535')]
    public string $trade_off_description = '';

    #[Validate([
        'target_profiles' => ['nullable', 'array'],
        'target_profiles.*' => ['integer', new Enum(PropertyTargetProfile::class)],
    ])]
    public array $target_profiles = [];

    #[Validate(['nullable', 'integer', new Enum(PropertyOperationalRisk::class)])]
    public ?int $operational_risk = null;

    #[Validate('nullable|string|min:1|max:65535')]
    public string $operational_risk_comment = '';

    #[Validate('required|integer|min:0|max:100000000000')]
    public int $monthly_price = 0;

    #[Validate('required|integer|min:0|max:100000000000')]
    public int $yearly_price = 0;

    #[Validate('nullable|array')]
    public array $monthly_inclusions = [
        'housekeeper' => false,
        'housekeeper_frequency' => null,
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
        'housekeeper_frequency' => null,
        'gardener' => false,
        'pool_guy' => false,
        'internet' => false,
        'garbage' => false,
        'banjar' => false,
        'security' => false,
        'electricity' => false,
        'others' => null,
    ];

    #[Validate(['nullable', 'integer', new Enum(PropertyStatus::class)])]
    public int $status = PropertyStatus::Pending->value;

    // #[Validate('nullable|image|file|mimes:jpg,jpeg,png,gif,webp|max:12288')]
    // public ?TemporaryUploadedFile $image = null;

    #[Validate(['nullable', 'array', 'min:0'])]
    public array $images = [];

    public function submit(): Property
    {
        return (new PropertyService)->create(data: $this->validate());
    }
}
