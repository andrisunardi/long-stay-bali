<?php

namespace App\Models;

use App\Observers\AreaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property int $district_id
 * @property string $name
 * @property bool $is_promoted
 * @property bool $is_show
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read District|null $district
 * @property-read Collection<int, Property> $properties
 * @property-read int|null $properties_count
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|Area active()
 * @method static \Database\Factories\AreaFactory factory($count = null, $state = [])
 * @method static Builder<static>|Area inactive()
 * @method static Builder<static>|Area newModelQuery()
 * @method static Builder<static>|Area newQuery()
 * @method static Builder<static>|Area notPromoted()
 * @method static Builder<static>|Area notShown()
 * @method static Builder<static>|Area onlyTrashed()
 * @method static Builder<static>|Area promoted()
 * @method static Builder<static>|Area query()
 * @method static Builder<static>|Area show()
 * @method static Builder<static>|Area whereCreatedAt($value)
 * @method static Builder<static>|Area whereCreatedBy($value)
 * @method static Builder<static>|Area whereDeletedAt($value)
 * @method static Builder<static>|Area whereDeletedBy($value)
 * @method static Builder<static>|Area whereDistrictId($value)
 * @method static Builder<static>|Area whereId($value)
 * @method static Builder<static>|Area whereIsActive($value)
 * @method static Builder<static>|Area whereIsPromoted($value)
 * @method static Builder<static>|Area whereIsShow($value)
 * @method static Builder<static>|Area whereName($value)
 * @method static Builder<static>|Area whereUpdatedAt($value)
 * @method static Builder<static>|Area whereUpdatedBy($value)
 * @method static Builder<static>|Area withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Area withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([AreaObserver::class])]
class Area extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'areas';

    protected $fillable = [
        'district_id',
        'name',
        'is_promoted',
        'is_show',
        'is_active',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'district_id' => 'integer',
            'name' => 'string',
            'is_promoted' => 'boolean',
            'is_show' => 'boolean',
            'is_active' => 'boolean',
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

    public function scopePromoted(Builder $query): void
    {
        $query->where('is_promoted', true);
    }

    public function scopeNotPromoted(Builder $query): void
    {
        $query->where('is_promoted', false);
    }

    public function scopeShow(Builder $query): void
    {
        $query->where('is_show', true);
    }

    public function scopeNotShown(Builder $query): void
    {
        $query->where('is_show', false);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('is_active', false);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
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
