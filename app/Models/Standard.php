<?php

namespace App\Models;

use App\Observers\StandardObserver;
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
 * @property string $title_fr
 * @property string $description
 * @property string $description_id
 * @property string $description_zh
 * @property string $description_fr
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
 * @property-read string $translate_title
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|Standard active()
 * @method static \Database\Factories\StandardFactory factory($count = null, $state = [])
 * @method static Builder<static>|Standard inactive()
 * @method static Builder<static>|Standard newModelQuery()
 * @method static Builder<static>|Standard newQuery()
 * @method static Builder<static>|Standard onlyTrashed()
 * @method static Builder<static>|Standard query()
 * @method static Builder<static>|Standard whereCreatedAt($value)
 * @method static Builder<static>|Standard whereCreatedBy($value)
 * @method static Builder<static>|Standard whereDeletedAt($value)
 * @method static Builder<static>|Standard whereDeletedBy($value)
 * @method static Builder<static>|Standard whereDescription($value)
 * @method static Builder<static>|Standard whereDescriptionFr($value)
 * @method static Builder<static>|Standard whereDescriptionId($value)
 * @method static Builder<static>|Standard whereDescriptionZh($value)
 * @method static Builder<static>|Standard whereId($value)
 * @method static Builder<static>|Standard whereIsActive($value)
 * @method static Builder<static>|Standard whereTitle($value)
 * @method static Builder<static>|Standard whereTitleFr($value)
 * @method static Builder<static>|Standard whereTitleId($value)
 * @method static Builder<static>|Standard whereTitleZh($value)
 * @method static Builder<static>|Standard whereUpdatedAt($value)
 * @method static Builder<static>|Standard whereUpdatedBy($value)
 * @method static Builder<static>|Standard withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Standard withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([StandardObserver::class])]
class Standard extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'standards';

    protected $fillable = [
        'title',
        'title_id',
        'title_zh',
        'title_fr',
        'description',
        'description_id',
        'description_zh',
        'description_fr',
        'is_active',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'title' => 'string',
            'title_id' => 'string',
            'title_zh' => 'string',
            'title_fr' => 'string',
            'description' => 'string',
            'description_id' => 'string',
            'description_zh' => 'string',
            'description_fr' => 'string',
            'is_active' => 'boolean',
        ];
    }

    public array $translatable = [
        'title',
        'description',
    ];

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
