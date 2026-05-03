<?php

namespace App\Models;

use App\Observers\GuideCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string $name_id
 * @property string $name_zh
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
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read string $translate_name
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|GuideCategory active()
 * @method static \Database\Factories\GuideCategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|GuideCategory inactive()
 * @method static Builder<static>|GuideCategory newModelQuery()
 * @method static Builder<static>|GuideCategory newQuery()
 * @method static Builder<static>|GuideCategory notShown()
 * @method static Builder<static>|GuideCategory onlyTrashed()
 * @method static Builder<static>|GuideCategory query()
 * @method static Builder<static>|GuideCategory show()
 * @method static Builder<static>|GuideCategory whereCreatedAt($value)
 * @method static Builder<static>|GuideCategory whereCreatedBy($value)
 * @method static Builder<static>|GuideCategory whereDeletedAt($value)
 * @method static Builder<static>|GuideCategory whereDeletedBy($value)
 * @method static Builder<static>|GuideCategory whereId($value)
 * @method static Builder<static>|GuideCategory whereIsActive($value)
 * @method static Builder<static>|GuideCategory whereIsShow($value)
 * @method static Builder<static>|GuideCategory whereName($value)
 * @method static Builder<static>|GuideCategory whereNameId($value)
 * @method static Builder<static>|GuideCategory whereNameZh($value)
 * @method static Builder<static>|GuideCategory whereUpdatedAt($value)
 * @method static Builder<static>|GuideCategory whereUpdatedBy($value)
 * @method static Builder<static>|GuideCategory withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|GuideCategory withoutTrashed()
 *
 * @property-read Collection<int, Guide> $guides
 * @property-read int|null $guides_count
 *
 * @mixin \Eloquent
 */
#[ObservedBy([GuideCategoryObserver::class])]
class GuideCategory extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'guide_categories';

    protected $fillable = [
        'name',
        'name_id',
        'name_zh',
        'is_show',
        'is_active',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'name_id' => 'string',
            'name_zh' => 'string',
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

    public function getTranslateNameAttribute(): string
    {
        $locale = App::getLocale();
        $language = [
            'en' => $this->name,
            'id' => $this->name_id,
            'zh' => $this->name_zh,
        ];

        return $language[$locale] ?? $this->name;
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

    public function guides(): HasMany
    {
        return $this->hasMany(Guide::class);
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
