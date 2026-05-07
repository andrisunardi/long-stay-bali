<?php

namespace App\Models;

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
use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int|null $user_id
 * @property Carbon|null $availability_date
 * @property Carbon|null $visit_date
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $address
 * @property int|null $district_id
 * @property int|null $area_id
 * @property int|null $land_size
 * @property int|null $building_size
 * @property int|null $number_of_floors
 * @property int|null $outdoor_area_size
 * @property string|null $pool_size
 * @property bool|null $number_of_bathrooms
 * @property bool $ensuite_bathrooms
 * @property bool $guest_toilet
 * @property bool $storage
 * @property PropertyLivingStyle|null $living_style
 * @property bool $full_legal_documentation
 * @property bool $signed_listing_agreement
 * @property bool $lease_agreement
 * @property bool $land_certificate
 * @property bool $owners_id
 * @property bool $imb
 * @property bool $pbg
 * @property bool $slf
 * @property bool $fully_furnished
 * @property PropertyRentalType|null $rental_type
 * @property int|null $minimum_rental_duration_months
 * @property PropertyOwnerPriceFlexibility|null $owner_price_flexibility
 * @property bool $price_coherent_with_upper
 * @property bool $not_directly_exposed_to_main_road
 * @property bool $no_festive_venue_nearby
 * @property bool $no_ongoing
 * @property bool $quiet_access_road
 * @property PropertyOrientation|null $orientation
 * @property string|null $view
 * @property bool $living_area_has_natural_light
 * @property bool $bedroom_1_has_natural_light
 * @property bool $bedroom_2_has_natural_light
 * @property string|null $noise_source_identified
 * @property int|null $internet_speedtest
 * @property string|null $internet_speedtest_image_path
 * @property PropertyPowerBackup|null $power_backup
 * @property PropertyWaterSource|null $water_source
 * @property PropertyElectricity|null $electricity
 * @property bool $eligible_for_upper
 * @property bool $eligible_for_premium
 * @property bool $design_driven_property
 * @property string|null $usability_limitations
 * @property bool $trade_off_identified
 * @property string|null $trade_off_description
 * @property array<array-key, mixed>|null $target_profiles
 * @property PropertyOperationalRisk|null $operational_risk
 * @property string|null $operational_risk_comment
 * @property string|null $image_path
 * @property PropertyStatus $status
 * @property string $slug
 * @property string|null $folder_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Area|null $area
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read District|null $district
 * @property-read string $image
 * @property-read string $internet_speedtest_image
 * @property-read Property|null $images
 * @property-read User|null $updatedBy
 * @property-read User|null $user
 *
 * @method static Builder<static>|Property acceptPremium()
 * @method static Builder<static>|Property acceptUpper()
 * @method static Builder<static>|Property afternoon()
 * @method static Builder<static>|Property both()
 * @method static Builder<static>|Property closed()
 * @method static Builder<static>|Property couple()
 * @method static Builder<static>|Property designLover()
 * @method static Builder<static>|Property eSolar()
 * @method static Builder<static>|Property escalate()
 * @method static \Database\Factories\PropertyFactory factory($count = null, $state = [])
 * @method static Builder<static>|Property family()
 * @method static Builder<static>|Property fixed()
 * @method static Builder<static>|Property generator()
 * @method static Builder<static>|Property high()
 * @method static Builder<static>|Property hybrid()
 * @method static Builder<static>|Property low()
 * @method static Builder<static>|Property medium()
 * @method static Builder<static>|Property mixed()
 * @method static Builder<static>|Property mixedSun()
 * @method static Builder<static>|Property monthly()
 * @method static Builder<static>|Property morning()
 * @method static Builder<static>|Property negotiable()
 * @method static Builder<static>|Property newModelQuery()
 * @method static Builder<static>|Property newQuery()
 * @method static Builder<static>|Property none()
 * @method static Builder<static>|Property onlyTrashed()
 * @method static Builder<static>|Property open()
 * @method static Builder<static>|Property pDAM()
 * @method static Builder<static>|Property pending()
 * @method static Builder<static>|Property query()
 * @method static Builder<static>|Property reject()
 * @method static Builder<static>|Property remoteWorker()
 * @method static Builder<static>|Property solar()
 * @method static Builder<static>|Property standard()
 * @method static Builder<static>|Property wSMixed()
 * @method static Builder<static>|Property well()
 * @method static Builder<static>|Property whereAddress($value)
 * @method static Builder<static>|Property whereAreaId($value)
 * @method static Builder<static>|Property whereAvailabilityDate($value)
 * @method static Builder<static>|Property whereBedroom1HasNaturalLight($value)
 * @method static Builder<static>|Property whereBedroom2HasNaturalLight($value)
 * @method static Builder<static>|Property whereBuildingSize($value)
 * @method static Builder<static>|Property whereCode($value)
 * @method static Builder<static>|Property whereCreatedAt($value)
 * @method static Builder<static>|Property whereCreatedBy($value)
 * @method static Builder<static>|Property whereDeletedAt($value)
 * @method static Builder<static>|Property whereDeletedBy($value)
 * @method static Builder<static>|Property whereDesignDrivenProperty($value)
 * @method static Builder<static>|Property whereDistrictId($value)
 * @method static Builder<static>|Property whereElectricity($value)
 * @method static Builder<static>|Property whereEligibleForPremium($value)
 * @method static Builder<static>|Property whereEligibleForUpper($value)
 * @method static Builder<static>|Property whereEnsuiteBathrooms($value)
 * @method static Builder<static>|Property whereFolderId($value)
 * @method static Builder<static>|Property whereFullLegalDocumentation($value)
 * @method static Builder<static>|Property whereFullyFurnished($value)
 * @method static Builder<static>|Property whereGuestToilet($value)
 * @method static Builder<static>|Property whereId($value)
 * @method static Builder<static>|Property whereImagePath($value)
 * @method static Builder<static>|Property whereImb($value)
 * @method static Builder<static>|Property whereInternetSpeedtest($value)
 * @method static Builder<static>|Property whereInternetSpeedtestImagePath($value)
 * @method static Builder<static>|Property whereLandCertificate($value)
 * @method static Builder<static>|Property whereLandSize($value)
 * @method static Builder<static>|Property whereLatitude($value)
 * @method static Builder<static>|Property whereLeaseAgreement($value)
 * @method static Builder<static>|Property whereLivingAreaHasNaturalLight($value)
 * @method static Builder<static>|Property whereLivingStyle($value)
 * @method static Builder<static>|Property whereLongitude($value)
 * @method static Builder<static>|Property whereMinimumRentalDurationMonths($value)
 * @method static Builder<static>|Property whereName($value)
 * @method static Builder<static>|Property whereNoFestiveVenueNearby($value)
 * @method static Builder<static>|Property whereNoOngoing($value)
 * @method static Builder<static>|Property whereNoiseSourceIdentified($value)
 * @method static Builder<static>|Property whereNotDirectlyExposedToMainRoad($value)
 * @method static Builder<static>|Property whereNumberOfBathrooms($value)
 * @method static Builder<static>|Property whereNumberOfFloors($value)
 * @method static Builder<static>|Property whereOperationalRisk($value)
 * @method static Builder<static>|Property whereOperationalRiskComment($value)
 * @method static Builder<static>|Property whereOrientation($value)
 * @method static Builder<static>|Property whereOutdoorAreaSize($value)
 * @method static Builder<static>|Property whereOwnerPriceFlexibility($value)
 * @method static Builder<static>|Property whereOwnersId($value)
 * @method static Builder<static>|Property wherePbg($value)
 * @method static Builder<static>|Property wherePoolSize($value)
 * @method static Builder<static>|Property wherePowerBackup($value)
 * @method static Builder<static>|Property wherePriceCoherentWithUpper($value)
 * @method static Builder<static>|Property whereQuietAccessRoad($value)
 * @method static Builder<static>|Property whereRentalType($value)
 * @method static Builder<static>|Property whereSignedListingAgreement($value)
 * @method static Builder<static>|Property whereSlf($value)
 * @method static Builder<static>|Property whereSlug($value)
 * @method static Builder<static>|Property whereStatus($value)
 * @method static Builder<static>|Property whereStorage($value)
 * @method static Builder<static>|Property whereTargetProfiles($value)
 * @method static Builder<static>|Property whereTradeOffDescription($value)
 * @method static Builder<static>|Property whereTradeOffIdentified($value)
 * @method static Builder<static>|Property whereUpdatedAt($value)
 * @method static Builder<static>|Property whereUpdatedBy($value)
 * @method static Builder<static>|Property whereUsabilityLimitations($value)
 * @method static Builder<static>|Property whereUserId($value)
 * @method static Builder<static>|Property whereView($value)
 * @method static Builder<static>|Property whereVisitDate($value)
 * @method static Builder<static>|Property whereWaterSource($value)
 * @method static Builder<static>|Property withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Property withoutTrashed()
 * @method static Builder<static>|Property yearly()
 *
 * @property-read int|null $images_count
 * @property string|null $description
 * @property string|null $description_id
 * @property string|null $description_zh
 * @property string|null $description_fr
 * @property-read string $translate_description
 *
 * @method static Builder<static>|Property whereDescription($value)
 * @method static Builder<static>|Property whereDescriptionFr($value)
 * @method static Builder<static>|Property whereDescriptionId($value)
 * @method static Builder<static>|Property whereDescriptionZh($value)
 *
 * @property string|null $google_maps_url
 * @property int $monthly_price
 * @property int $yearly_price
 *
 * @method static Builder<static>|Property whereGoogleMapsUrl($value)
 * @method static Builder<static>|Property whereMonthlyPrice($value)
 * @method static Builder<static>|Property whereYearlyPrice($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([PropertyObserver::class])]
class Property extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'properties';

    protected $fillable = [
        'code',
        'name',
        'description',
        'description_id',
        'description_fr',
        'user_id',
        'availability_date',
        'visit_date',

        'google_maps_url',
        'latitude',
        'longitude',
        'address',
        'district_id',
        'area_id',

        'land_size',
        'building_size',
        'number_of_floors',
        'outdoor_area_size',
        'pool_size',

        'number_of_bathrooms',
        'ensuite_bathrooms',
        'guest_toilet',
        'storage',
        'living_style',

        'full_legal_documentation',
        'signed_listing_agreement',
        'lease_agreement',
        'land_certificate',
        'owners_id',
        'imb',
        'pbg',
        'slf',

        'fully_furnished',
        'rental_type',
        'minimum_rental_duration_months',
        'owner_price_flexibility',
        'price_coherent_with_upper',

        'not_directly_exposed_to_main_road',
        'no_festive_venue_nearby',
        'no_ongoing',
        'quiet_access_road',
        'orientation',
        'view',

        'living_area_has_natural_light',
        'bedroom_1_has_natural_light',
        'bedroom_2_has_natural_light',
        'noise_source_identified',

        'internet_speedtest',
        'internet_speedtest_image_path',
        'power_backup',
        'water_source',
        'electricity',

        'eligible_for_upper',
        'eligible_for_premium',

        'design_driven_property',
        'usability_limitations',

        'trade_off_identified',
        'trade_off_description',
        'target_profiles',

        'operational_risk',
        'operational_risk_comment',

        'monthly_price',
        'yearly_price',

        'image_path',
        'status',
        'slug',
        'folder_id',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'code' => 'string',
            'name' => 'string',
            'description' => 'string',
            'description_id' => 'string',
            'description_fr' => 'string',
            'user_id' => 'integer',
            'availability_date' => 'date',
            'visit_date' => 'date',

            'google_maps_url' => 'string',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'address' => 'string',
            'district_id' => 'integer',
            'area_id' => 'integer',

            'land_size' => 'integer',
            'building_size' => 'integer',
            'number_of_floors' => 'integer',
            'outdoor_area_size' => 'integer',
            'pool_size' => 'string',

            'number_of_bathrooms' => 'boolean',
            'ensuite_bathrooms' => 'boolean',
            'guest_toilet' => 'boolean',
            'storage' => 'boolean',
            'living_style' => PropertyLivingStyle::class,

            'full_legal_documentation' => 'boolean',
            'signed_listing_agreement' => 'boolean',
            'lease_agreement' => 'boolean',
            'land_certificate' => 'boolean',
            'owners_id' => 'boolean',
            'imb' => 'boolean',
            'pbg' => 'boolean',
            'slf' => 'boolean',

            'fully_furnished' => 'boolean',
            'rental_type' => PropertyRentalType::class,
            'minimum_rental_duration_months' => 'integer',
            'owner_price_flexibility' => PropertyOwnerPriceFlexibility::class,
            'price_coherent_with_upper' => 'boolean',

            'not_directly_exposed_to_main_road' => 'boolean',
            'no_festive_venue_nearby' => 'boolean',
            'no_ongoing' => 'boolean',
            'quiet_access_road' => 'boolean',
            'orientation' => PropertyOrientation::class,
            'view' => 'string',

            'living_area_has_natural_light' => 'boolean',
            'bedroom_1_has_natural_light' => 'boolean',
            'bedroom_2_has_natural_light' => 'boolean',
            'noise_source_identified' => 'string',

            'internet_speedtest' => 'integer',
            'internet_speedtest_image_path' => 'string',
            'power_backup' => PropertyPowerBackup::class,
            'water_source' => PropertyWaterSource::class,
            'electricity' => PropertyElectricity::class,

            'eligible_for_upper' => 'boolean',
            'eligible_for_premium' => 'boolean',

            'design_driven_property' => 'boolean',
            'usability_limitations' => 'string',

            'trade_off_identified' => 'boolean',
            'trade_off_description' => 'string',
            'target_profiles' => 'json',

            'operational_risk' => PropertyOperationalRisk::class,
            'operational_risk_comment' => 'string',

            'monthly_price' => 'integer',
            'yearly_price' => 'integer',

            'image_path' => 'string',
            'status' => PropertyStatus::class,
            'slug' => 'string',
            'folder_id' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->table)
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => ":subject.name has been {$eventName} by :causer.name");
    }

    public function getCreatedAtAttribute(string $value): Carbon
    {
        return Carbon::parse($value)->setTimezone(config('app.timezone'));
    }

    public function getUpdatedAtAttribute(string $value): Carbon
    {
        return Carbon::parse($value)->setTimezone(config('app.timezone'));
    }

    public function getTranslateDescriptionAttribute(): ?string
    {
        $locale = App::getLocale();
        $language = [
            'en' => $this->description,
            'id' => $this->description_id,
            'zh' => $this->description_zh,
            'fr' => $this->description_fr,
        ];

        return $language[$locale] ?? $this->description;
    }

    // public function getImageAttribute(): string
    // {
    //     return "https://lh3.googleusercontent.com/d/{$this->image_path}";
    // }

    // public function getInternetSpeedtestImageAttribute(): string
    // {
    //     return "https://lh3.googleusercontent.com/d/{$this->internet_speedtest_image_path}";
    // }

    public function scopeOpen(Builder $query): void
    {
        $query->where('living_style', PropertyLivingStyle::Open);
    }

    public function scopeClosed(Builder $query): void
    {
        $query->where('living_style', PropertyLivingStyle::Closed);
    }

    public function scopeMixed(Builder $query): void
    {
        $query->where('living_style', PropertyLivingStyle::Mixed);
    }

    public function scopeMonthly(Builder $query): void
    {
        $query->where('rental_type', PropertyRentalType::Monthly);
    }

    public function scopeYearly(Builder $query): void
    {
        $query->where('rental_type', PropertyRentalType::Yearly);
    }

    public function scopeBoth(Builder $query): void
    {
        $query->where('rental_type', PropertyRentalType::Both);
    }

    public function scopeFixed(Builder $query): void
    {
        $query->where('price_flexibility', PropertyOwnerPriceFlexibility::Fixed);
    }

    public function scopeNegotiable(Builder $query): void
    {
        $query->where('price_flexibility', PropertyOwnerPriceFlexibility::Negotiable);
    }

    public function scopeMorning(Builder $query): void
    {
        $query->where('orientation', PropertyOrientation::Morning);
    }

    public function scopeAfternoon(Builder $query): void
    {
        $query->where('orientation', PropertyOrientation::Afternoon);
    }

    public function scopeMixedSun(Builder $query): void
    {
        $query->where('orientation', PropertyOrientation::MixedSun);
    }

    public function scopeGenerator(Builder $query): void
    {
        $query->where('power_backup', PropertyPowerBackup::Generator);
    }

    public function scopeSolar(Builder $query): void
    {
        $query->where('power_backup', PropertyPowerBackup::Solar);
    }

    public function scopeNone(Builder $query): void
    {
        $query->where('power_backup', PropertyPowerBackup::None);
    }

    public function scopePDAM(Builder $query): void
    {
        $query->where('water_source', PropertyWaterSource::PDAM);
    }

    public function scopeWell(Builder $query): void
    {
        $query->where('water_source', PropertyWaterSource::Well);
    }

    public function scopeWSMixed(Builder $query): void
    {
        $query->where('water_source', PropertyWaterSource::Mixed);
    }

    public function scopeStandard(Builder $query): void
    {
        $query->where('electricity', PropertyElectricity::Standard);
    }

    public function scopeESolar(Builder $query): void
    {
        $query->where('electricity', PropertyElectricity::Solar);
    }

    public function scopeHybrid(Builder $query): void
    {
        $query->where('electricity', PropertyElectricity::Hybrid);
    }

    public function scopeFamily(Builder $query): void
    {
        $query->where('target_profile', PropertyTargetProfile::Family);
    }

    public function scopeCouple(Builder $query): void
    {
        $query->where('target_profile', PropertyTargetProfile::Couple);
    }

    public function scopeRemoteWorker(Builder $query): void
    {
        $query->where('target_profile', PropertyTargetProfile::RemoteWorker);
    }

    public function scopeDesignLover(Builder $query): void
    {
        $query->where('target_profile', PropertyTargetProfile::DesignLover);
    }

    public function scopeLow(Builder $query): void
    {
        $query->where('operational_risk', PropertyOperationalRisk::Low);
    }

    public function scopeMedium(Builder $query): void
    {
        $query->where('operational_risk', PropertyOperationalRisk::Medium);
    }

    public function scopeHigh(Builder $query): void
    {
        $query->where('operational_risk', PropertyOperationalRisk::High);
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', PropertyStatus::Pending);
    }

    public function scopeAcceptUpper(Builder $query): void
    {
        $query->where('status', PropertyStatus::AcceptUpper);
    }

    public function scopeAcceptPremium(Builder $query): void
    {
        $query->where('status', PropertyStatus::AcceptPremium);
    }

    public function scopeReject(Builder $query): void
    {
        $query->where('status', PropertyStatus::Reject);
    }

    public function scopeEscalate(Builder $query): void
    {
        $query->where('status', PropertyStatus::Escalate);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(PropertyImage::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
