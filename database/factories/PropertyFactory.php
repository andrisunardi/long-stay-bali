<?php

namespace Database\Factories;

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
use App\Models\Area;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        $user = User::first() ?? User::factory()->create();
        $district = District::first() ?? District::factory()->create();
        $area = Area::first() ?? Area::factory()->create();

        $code = Str::random(10);
        $description = fake()->unique()->paragraph();
        $slug = Str::slug($code);

        return [
            'code' => $code,
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'description_id' => (new GoogleTranslate('id'))->translate($description),
            'description_zh' => (new GoogleTranslate('zh'))->translate($description),
            'description_fr' => (new GoogleTranslate('fr'))->translate($description),
            'user_id' => $user->id,
            'availability_date' => fake()->date(),
            'visit_date' => fake()->date(),
            'bedroom' => fake()->randomElement(PropertyBedroom::cases()),

            'villa_name' => fake()->name(),
            'google_maps_url' => fake()->url(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'address' => fake()->address(),
            'district_id' => $district->id,
            'area_id' => $area->id,

            'land_size' => fake()->numberBetween(1, 100),
            'building_size' => fake()->numberBetween(1, 100),
            'number_of_floors' => fake()->numberBetween(1, 100),
            'outdoor_area_size' => fake()->numberBetween(1, 100),
            'pool_size' => fake()->numberBetween(1, 100),

            'number_of_bathrooms' => fake()->numberBetween(1, 100),
            'ensuite_bathrooms' => fake()->boolean(),
            'guest_toilet' => fake()->boolean(),
            'storage' => fake()->boolean(),
            'living_style' => fake()->randomElement(PropertyLivingStyle::cases()),

            'full_legal_documentation' => fake()->boolean(),
            'signed_listing_agreement' => fake()->boolean(),
            'lease_agreement' => fake()->boolean(),
            'land_certificate' => fake()->boolean(),
            'owners_id' => fake()->boolean(),
            'imb' => fake()->boolean(),
            'pbg' => fake()->boolean(),
            'slf' => fake()->boolean(),

            'fully_furnished' => fake()->boolean(),
            'rental_type' => fake()->randomElement(PropertyRentalType::cases()),
            'minimum_rental_duration_months' => fake()->numberBetween(1, 12),
            'owner_price_flexibility' => fake()->randomElement(PropertyOwnerPriceFlexibility::cases()),
            'price_coherent_with_upper' => fake()->boolean(),

            'not_directly_exposed_to_main_road' => fake()->boolean(),
            'no_festive_venue_nearby' => fake()->boolean(),
            'no_ongoing' => fake()->boolean(),
            'quiet_access_road' => fake()->boolean(),
            'orientation' => fake()->randomElement(PropertyOrientation::cases()),
            'view' => fake()->text(),

            'living_area_has_natural_light' => fake()->boolean(),
            'bedroom_1_has_natural_light' => fake()->boolean(),
            'bedroom_2_has_natural_light' => fake()->boolean(),
            'noise_source_identified' => fake()->text(),

            'internet_speedtest' => fake()->numberBetween(1, 100),
            'internet_speedtest_image_path' => null,
            'power_backup' => fake()->randomElement(PropertyPowerBackup::cases()),
            'water_source' => fake()->randomElement(PropertyWaterSource::cases()),
            'electricity' => fake()->randomElement(PropertyElectricity::cases()),

            'eligible_for_upper' => fake()->boolean(),
            'eligible_for_premium' => fake()->boolean(),

            'design_driven_property' => fake()->boolean(),
            'usability_limitations' => fake()->text(),

            'trade_off_identified' => fake()->boolean(),
            'trade_off_description' => fake()->text(),
            'target_profiles' => [fake()->randomElement(PropertyTargetProfile::cases())],

            'operational_risk' => fake()->randomElement(PropertyOperationalRisk::cases()),
            'operational_risk_comment' => fake()->text(),

            'monthly_price' => fake()->numberBetween(100, 1000),
            'yearly_price' => fake()->numberBetween(100, 1000),

            'image_path' => null,
            'status' => fake()->randomElement(PropertyStatus::cases()),
            'slug' => $slug,
            'folder_id' => null,
        ];
    }
}
