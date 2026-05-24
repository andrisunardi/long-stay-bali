<?php

namespace App\Models;

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Observers\ContactObserver;
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
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $company
 * @property string $email
 * @property string $phone
 * @property PropertyBedroom|null $bedroom
 * @property PropertyRentalType|null $rental_type
 * @property string|null $message
 * @property int|null $area_id
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
 * @property-read mixed $properties
 * @property-read Collection<int, Property> $ownerRepresentatives
 * @property-read int|null $owner_representatives_count
 * @property-read Collection<int, Property> $owners
 * @property-read int|null $owners_count
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|Contact both()
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static Builder<static>|Contact fourBedroom()
 * @method static Builder<static>|Contact monthly()
 * @method static Builder<static>|Contact newModelQuery()
 * @method static Builder<static>|Contact newQuery()
 * @method static Builder<static>|Contact oneBedroom()
 * @method static Builder<static>|Contact onlyTrashed()
 * @method static Builder<static>|Contact query()
 * @method static Builder<static>|Contact threeBedroom()
 * @method static Builder<static>|Contact twoBedroom()
 * @method static Builder<static>|Contact whereAreaId($value)
 * @method static Builder<static>|Contact whereBedroom($value)
 * @method static Builder<static>|Contact whereCode($value)
 * @method static Builder<static>|Contact whereCompany($value)
 * @method static Builder<static>|Contact whereCreatedAt($value)
 * @method static Builder<static>|Contact whereCreatedBy($value)
 * @method static Builder<static>|Contact whereDeletedAt($value)
 * @method static Builder<static>|Contact whereDeletedBy($value)
 * @method static Builder<static>|Contact whereEmail($value)
 * @method static Builder<static>|Contact whereFirstName($value)
 * @method static Builder<static>|Contact whereId($value)
 * @method static Builder<static>|Contact whereLastName($value)
 * @method static Builder<static>|Contact whereMessage($value)
 * @method static Builder<static>|Contact whereName($value)
 * @method static Builder<static>|Contact wherePhone($value)
 * @method static Builder<static>|Contact whereRentalType($value)
 * @method static Builder<static>|Contact whereUpdatedAt($value)
 * @method static Builder<static>|Contact whereUpdatedBy($value)
 * @method static Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Contact withoutTrashed()
 * @method static Builder<static>|Contact yearly()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([ContactObserver::class])]
class Contact extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'code',
        'name',
        'first_name',
        'last_name',
        'company',
        'phone',
        'email',
        'area_id',
        'bedroom',
        'rental_type',
        'message',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'code' => 'string',
            'name' => 'string',
            'first_name' => 'string',
            'last_name' => 'string',
            'company' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'area_id' => 'integer',
            'bedroom' => PropertyBedroom::class,
            'rental_type' => PropertyRentalType::class,
            'message' => 'string',
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

    public function scopeOneBedroom(Builder $query): void
    {
        $query->where('bedroom', PropertyBedroom::OneBedroom);
    }

    public function scopeTwoBedroom(Builder $query): void
    {
        $query->where('bedroom', PropertyBedroom::TwoBedroom);
    }

    public function scopeThreeBedroom(Builder $query): void
    {
        $query->where('bedroom', PropertyBedroom::ThreeBedroom);
    }

    public function scopeFourBedroom(Builder $query): void
    {
        $query->where('bedroom', PropertyBedroom::FourBedroom);
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

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function district(): HasOne
    {
        return $this->hasOne(District::class, Area::class);
    }

    public function owners(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function ownerRepresentatives(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_representative_id');
    }

    public function getPropertiesAttribute()
    {
        return $this->owners
            ->merge($this->ownerRepresentatives)
            ->unique('id')
            ->values();
    }
}
