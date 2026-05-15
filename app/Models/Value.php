<?php

namespace App\Models;

use App\Observers\ValueObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property string $title
 * @property string $title_id
 * @property string $title_zh
 * @property string $short_description
 * @property string $short_description_id
 * @property string $short_description_zh
 * @property string $description
 * @property string $description_id
 * @property string $description_zh
 * @property string $icon
 * @property bool $is_active
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
 * @property-read string $translate_description
 * @property-read string $translate_short_description
 * @property-read string $translate_title
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|Value active()
 * @method static \Database\Factories\ValueFactory factory($count = null, $state = [])
 * @method static Builder<static>|Value inactive()
 * @method static Builder<static>|Value newModelQuery()
 * @method static Builder<static>|Value newQuery()
 * @method static Builder<static>|Value onlyTrashed()
 * @method static Builder<static>|Value query()
 * @method static Builder<static>|Value whereCreatedAt($value)
 * @method static Builder<static>|Value whereCreatedBy($value)
 * @method static Builder<static>|Value whereDeletedAt($value)
 * @method static Builder<static>|Value whereDeletedBy($value)
 * @method static Builder<static>|Value whereDescription($value)
 * @method static Builder<static>|Value whereDescriptionId($value)
 * @method static Builder<static>|Value whereDescriptionZh($value)
 * @method static Builder<static>|Value whereIcon($value)
 * @method static Builder<static>|Value whereId($value)
 * @method static Builder<static>|Value whereIsActive($value)
 * @method static Builder<static>|Value whereShortDescription($value)
 * @method static Builder<static>|Value whereShortDescriptionId($value)
 * @method static Builder<static>|Value whereShortDescriptionZh($value)
 * @method static Builder<static>|Value whereTitle($value)
 * @method static Builder<static>|Value whereTitleId($value)
 * @method static Builder<static>|Value whereTitleZh($value)
 * @method static Builder<static>|Value whereUpdatedAt($value)
 * @method static Builder<static>|Value whereUpdatedBy($value)
 * @method static Builder<static>|Value withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Value withoutTrashed()
 *
 * @property string $title_fr
 * @property string $short_description_fr
 * @property string $description_fr
 *
 * @method static Builder<static>|Value whereDescriptionFr($value)
 * @method static Builder<static>|Value whereShortDescriptionFr($value)
 * @method static Builder<static>|Value whereTitleFr($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([ValueObserver::class])]
class Value extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'values';

    protected $fillable = [
        'title',
        'title_id',
        'title_zh',
        'title_fr',
        'short_description',
        'short_description_id',
        'short_description_zh',
        'short_description_fr',
        'description',
        'description_id',
        'description_zh',
        'description_fr',
        'icon',
        'is_active',
    ];

    public array $translatable = [
        'title',
        'short_description',
        'description',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'title' => 'string',
            'title_id' => 'string',
            'title_zh' => 'string',
            'title_fr' => 'string',
            'short_description' => 'string',
            'short_description_id' => 'string',
            'short_description_zh' => 'string',
            'short_description_fr' => 'string',
            'description' => 'string',
            'description_id' => 'string',
            'description_zh' => 'string',
            'description_fr' => 'string',
            'icon' => 'string',
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

    public function getTranslateTitleAttribute(): string
    {
        $locale = App::getLocale();
        $language = [
            'en' => $this->title,
            'id' => $this->title_id,
            'zh' => $this->title_zh,
            'fr' => $this->title_fr,
        ];

        return $language[$locale] ?? $this->title;
    }

    public function getTranslateShortDescriptionAttribute(): string
    {
        $locale = App::getLocale();
        $language = [
            'en' => $this->short_description,
            'id' => $this->short_description_id,
            'zh' => $this->short_description_zh,
            'fr' => $this->short_description_fr,
        ];

        return $language[$locale] ?? $this->short_description;
    }

    public function getTranslateDescriptionAttribute(): string
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

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('is_active', false);
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
