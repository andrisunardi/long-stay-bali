<?php

namespace App\Models;

use App\Observers\GuideObserver;
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
 * @property int $guide_category_id
 * @property string $title
 * @property string $title_id
 * @property string $title_zh
 * @property string $body
 * @property string $body_id
 * @property string $body_zh
 * @property string $google_file_id
 * @property string $image_url
 * @property bool $is_show
 * @property bool $is_active
 * @property string $slug
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read GuideCategory|null $category
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read string $translate_body
 * @property-read string $translate_title
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|Guide active()
 * @method static \Database\Factories\GuideFactory factory($count = null, $state = [])
 * @method static Builder<static>|Guide inactive()
 * @method static Builder<static>|Guide newModelQuery()
 * @method static Builder<static>|Guide newQuery()
 * @method static Builder<static>|Guide notShown()
 * @method static Builder<static>|Guide onlyTrashed()
 * @method static Builder<static>|Guide query()
 * @method static Builder<static>|Guide show()
 * @method static Builder<static>|Guide whereBody($value)
 * @method static Builder<static>|Guide whereBodyId($value)
 * @method static Builder<static>|Guide whereBodyZh($value)
 * @method static Builder<static>|Guide whereCreatedAt($value)
 * @method static Builder<static>|Guide whereCreatedBy($value)
 * @method static Builder<static>|Guide whereDeletedAt($value)
 * @method static Builder<static>|Guide whereDeletedBy($value)
 * @method static Builder<static>|Guide whereGoogleFileId($value)
 * @method static Builder<static>|Guide whereGuideCategoryId($value)
 * @method static Builder<static>|Guide whereId($value)
 * @method static Builder<static>|Guide whereImageUrl($value)
 * @method static Builder<static>|Guide whereIsActive($value)
 * @method static Builder<static>|Guide whereIsShow($value)
 * @method static Builder<static>|Guide whereSlug($value)
 * @method static Builder<static>|Guide whereTitle($value)
 * @method static Builder<static>|Guide whereTitleId($value)
 * @method static Builder<static>|Guide whereTitleZh($value)
 * @method static Builder<static>|Guide whereUpdatedAt($value)
 * @method static Builder<static>|Guide whereUpdatedBy($value)
 * @method static Builder<static>|Guide withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Guide withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([GuideObserver::class])]
class Guide extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'guides';

    protected $fillable = [
        'guide_category_id',
        'title',
        'title_id',
        'title_zh',
        'body',
        'body_id',
        'body_zh',
        'google_file_id',
        'image_url',
        'is_show',
        'is_active',
        'slug',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'guide_category_id' => 'integer',
            'title' => 'string',
            'title_id' => 'string',
            'title_zh' => 'string',
            'body' => 'string',
            'body_id' => 'string',
            'body_zh' => 'string',
            'google_file_id' => 'string',
            'image_url' => 'string',
            'is_show' => 'boolean',
            'is_active' => 'boolean',
            'slug' => 'string',
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
        ];

        return $language[$locale] ?? $this->title;
    }

    public function getTranslateBodyAttribute(): string
    {
        $locale = App::getLocale();
        $language = [
            'en' => $this->body,
            'id' => $this->body_id,
            'zh' => $this->body_zh,
        ];

        return $language[$locale] ?? $this->body;
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(GuideCategory::class, 'guide_category_id');
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
