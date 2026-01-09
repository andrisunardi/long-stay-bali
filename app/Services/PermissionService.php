<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    public function index(
        ?string $search = '',
        int|string|null $roleId = null,
        int|string|null $userId = null,
        bool $random = false,
        string $orderBy = 'id',
        string $sortBy = 'desc',
        int|string|null $limit = null,
        bool $first = false,
        bool $count = false,
        bool $paginate = true,
        int $perPage = 10,
    ): object|int|null {
        $permissions = Permission::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('guard_name', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'phone', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'email', 'like', "%{$search}%");
                });
            })
            ->when($roleId, fn ($q) => $q->whereRelation('roles', 'id', $roleId))
            ->when($userId, fn ($q) => $q->whereRelation('users', 'id', $userId))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $permissions->first();
        }

        if ($count) {
            return $permissions->count();
        }

        if ($paginate) {
            return $permissions->paginate($perPage);
        }

        return $permissions->get();
    }

    public function create(array $data = []): Permission
    {
        $roles = Role::whereIn('id', $data['role_ids'])->get();
        Arr::pull($data, 'role_ids');

        $table = (new Permission)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        $permission = Permission::create($data);
        $permission->assignRole($roles);

        return $permission;
    }

    public function update(Permission $permission, array $data = []): Permission
    {
        $roles = Role::whereIn('id', $data['role_ids'])->get();
        Arr::pull($data, 'role_ids');

        $permission->update($data);
        $permission->syncRoles($roles);
        $permission->refresh();

        return $permission;
    }

    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }
}
