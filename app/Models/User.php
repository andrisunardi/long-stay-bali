<?php

namespace App\Models;

use App\Enums\ConnectGroup\ConnectGroupCategory;
use App\Enums\ConnectGroup\ConnectGroupLevel;
use App\Enums\User\UserGender;
use App\Observers\UserObserver;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
/**
 * @property int $id
 * @property int|null $church_id
 * @property string $person_id
 * @property string|null $nij
 * @property string $name
 * @property UserGender $gender
 * @property Carbon|null $birth_date
 * @property int|null $age
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $photo_url
 * @property string|null $water_baptism_when
 * @property string|null $water_baptism_where
 * @property string|null $connect_groups
 * @property string|null $connect_group
 * @property string|null $connect_group_id
 * @property string|null $connect_group_name
 * @property ConnectGroupLevel|null $connect_group_level
 * @property ConnectGroupCategory|null $connect_group_category
 * @property string|null $connect_group_church_id
 * @property string|null $connect_group_church_name
 * @property int|null $connect_group_region_id
 * @property string|null $connect_group_region_name
 * @property string|null $connect_group_team_leader
 * @property string|null $connect_group_team_leader_person_id
 * @property string|null $connect_group_team_leader_name
 * @property string|null $connect_group_team_leader_nij
 * @property ConnectGroupCategory|null $connect_group_team_leader_category
 * @property ConnectGroupLevel|null $connect_group_team_leader_position
 * @property string|null $connect_group_team_leader_email
 * @property string|null $connect_group_team_leader_phone
 * @property string|null $connect_group_coach
 * @property string|null $connect_group_coach_person_id
 * @property string|null $connect_group_coach_name
 * @property string|null $connect_group_coach_nij
 * @property ConnectGroupCategory|null $connect_group_coach_category
 * @property ConnectGroupLevel|null $connect_group_coach_position
 * @property string|null $connect_group_coach_email
 * @property string|null $connect_group_coach_phone
 * @property string|null $connect_group_leader
 * @property string|null $connect_group_leader_person_id
 * @property string|null $connect_group_leader_name
 * @property string|null $connect_group_leader_nij
 * @property ConnectGroupCategory|null $connect_group_leader_category
 * @property ConnectGroupLevel|null $connect_group_leader_position
 * @property string|null $connect_group_leader_email
 * @property string|null $connect_group_leader_phone
 * @property Carbon|null $phone_verified_at
 * @property Carbon|null $email_verified_at
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Church|null $church
 * @property-read User|null $createdBy
 * @property-read User|null $deletedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Church|null $region
 * @property-read \App\Models\Registration|null $registration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read User|null $updatedBy
 *
 * @method static Builder<static>|User active()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User female()
 * @method static Builder<static>|User inactive()
 * @method static Builder<static>|User male()
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User whereAddress($value)
 * @method static Builder<static>|User whereAge($value)
 * @method static Builder<static>|User whereBirthDate($value)
 * @method static Builder<static>|User whereChurchId($value)
 * @method static Builder<static>|User whereCity($value)
 * @method static Builder<static>|User whereConnectGroup($value)
 * @method static Builder<static>|User whereConnectGroupCategory($value)
 * @method static Builder<static>|User whereConnectGroupChurchId($value)
 * @method static Builder<static>|User whereConnectGroupChurchName($value)
 * @method static Builder<static>|User whereConnectGroupCoach($value)
 * @method static Builder<static>|User whereConnectGroupCoachCategory($value)
 * @method static Builder<static>|User whereConnectGroupCoachEmail($value)
 * @method static Builder<static>|User whereConnectGroupCoachName($value)
 * @method static Builder<static>|User whereConnectGroupCoachNij($value)
 * @method static Builder<static>|User whereConnectGroupCoachPersonId($value)
 * @method static Builder<static>|User whereConnectGroupCoachPhone($value)
 * @method static Builder<static>|User whereConnectGroupCoachPosition($value)
 * @method static Builder<static>|User whereConnectGroupId($value)
 * @method static Builder<static>|User whereConnectGroupLeader($value)
 * @method static Builder<static>|User whereConnectGroupLeaderCategory($value)
 * @method static Builder<static>|User whereConnectGroupLeaderEmail($value)
 * @method static Builder<static>|User whereConnectGroupLeaderName($value)
 * @method static Builder<static>|User whereConnectGroupLeaderNij($value)
 * @method static Builder<static>|User whereConnectGroupLeaderPersonId($value)
 * @method static Builder<static>|User whereConnectGroupLeaderPhone($value)
 * @method static Builder<static>|User whereConnectGroupLeaderPosition($value)
 * @method static Builder<static>|User whereConnectGroupLevel($value)
 * @method static Builder<static>|User whereConnectGroupName($value)
 * @method static Builder<static>|User whereConnectGroupRegionId($value)
 * @method static Builder<static>|User whereConnectGroupRegionName($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeader($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderCategory($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderEmail($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderName($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderNij($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderPersonId($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderPhone($value)
 * @method static Builder<static>|User whereConnectGroupTeamLeaderPosition($value)
 * @method static Builder<static>|User whereConnectGroups($value)
 * @method static Builder<static>|User whereCountry($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereCreatedBy($value)
 * @method static Builder<static>|User whereDeletedAt($value)
 * @method static Builder<static>|User whereDeletedBy($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereGender($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereIsActive($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User whereNij($value)
 * @method static Builder<static>|User wherePersonId($value)
 * @method static Builder<static>|User wherePhone($value)
 * @method static Builder<static>|User wherePhoneVerifiedAt($value)
 * @method static Builder<static>|User wherePhotoUrl($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereUpdatedBy($value)
 * @method static Builder<static>|User whereWaterBaptismWhen($value)
 * @method static Builder<static>|User whereWaterBaptismWhere($value)
 * @method static Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @method static Builder<static>|User withoutTrashed()
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'phone_verified_at',
        'email_verified_at',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'phone_verified_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
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
        return Carbon::parse(config('app.timezone'));
    }

    public function getUpdatedAtAttribute(string $value): Carbon
    {
        return Carbon::parse(config('app.timezone'));
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
