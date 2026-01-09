<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserService
{
    public function index(
        ?string $search = null,
        array $isActive = [],
        int|string|null $roleId = null,
        string|array|null $roleName = null,
        int|string|null $permissionId = null,
        string|array|null $permissionName = null,
        bool $random = false,
        bool $trash = false,
        string $orderBy = 'id',
        string $sortBy = 'desc',
        int|string|null $limit = null,
        bool $first = false,
        bool $count = false,
        bool $paginate = true,
        int $perPage = 10,
    ): object|int|null {
        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($roleId, fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('id', $roleId)))
            ->when($roleName, fn ($q) => $q->role($roleName))
            ->when($permissionId, fn ($q) => $q->whereHas('permissions', fn ($r) => $r->where('id', $permissionId)))
            ->when($permissionName, fn ($q) => $q->permission($permissionName))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $users->first();
        }

        if ($count) {
            return $users->count();
        }

        if ($paginate) {
            return $users->paginate($perPage);
        }

        if ($paginate) {
            return $users->paginate($perPage);
        }

        return $users->get();
    }

    public function create(array $data = []): User
    {
        $table = (new User)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        return User::create($data);
    }

    public function update(User $user, array $data = []): User
    {
        if (isset($data['role_ids'])) {
            $roleIds = $data['role_ids'];
            Arr::pull($data, 'role_ids');

            $user->syncRoles($roleIds);
        }

        $user->update($data);
        $user->refresh();

        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function active(User $user): User
    {
        $user->is_active = ! $user->is_active;
        $user->save();
        $user->refresh();

        return $user;
    }

    public function assignRole(User $user, ?string $roleId = ''): User
    {
        $role = Role::find($roleId);
        $user->syncRoles($role);

        return $user->refresh();
    }
}
