<?php

namespace App\Models;

use App\Observers\PropertyImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property string|null $description
 * @property string|null $image_path
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read string $image
 * @property-read Property|null $property
 * @property-read User|null $updatedBy
 *
 * @method static \Database\Factories\PropertyImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage withoutTrashed()
 *
 * @property string $image_url
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereImageUrl($value)
 *
 * @property string $position
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage wherePosition($value)
 *
 * @property string $google_file_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereGoogleFileId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([PropertyImageObserver::class])]
class PropertyImage extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'property_images';

    protected $fillable = [
        'property_id',
        'name',
        'google_file_id',
        'image_url',
        'position',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'property_id' => 'integer',
            'name' => 'string',
            'google_file_id' => 'string',
            'image_url' => 'string',
            'position' => 'integer',
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

    // public function getImageAttribute(): string
    // {
    //     return "https://lh3.googleusercontent.com/d/{$this->image_path}";
    // }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
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
