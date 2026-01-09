<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index(
        ?string $search = '',
        int|string|null $permissionId = null,
        int|string|null $userId = null,
        bool $random = false,
        string $orderBy = 'id',
        string $sortBy = 'desc',
        ?string $limit = null,
        bool $first = false,
        bool $count = false,
        bool $paginate = true,
        int $perPage = 10,
    ): object|int|null {
        $roles = Role::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('guard_name', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'phone', 'like', "%{$search}%")
                        ->orWhereRelation('users', 'email', 'like', "%{$search}%");
                });
            })
            ->when($permissionId, fn ($q) => $q->whereRelation('permissions', 'id', $permissionId))
            ->when($userId, fn ($q) => $q->whereRelation('users', 'id', $userId))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $roles->first();
        }

        if ($count) {
            return $roles->count();
        }

        if ($paginate) {
            return $roles->paginate($perPage);
        }

        return $roles->get();
    }

    public function create(array $data = []): Role
    {
        $permissions = Permission::whereIn('id', $data['permission_ids'])->get();
        Arr::pull($data, 'permission_ids');

        $table = (new Role)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        $role = Role::create($data);
        $role->givePermissionTo($permissions);

        return $role;
    }

    public function update(Role $role, array $data = []): Role
    {
        $permissions = Permission::whereIn('id', $data['permission_ids'])->get();
        Arr::pull($data, 'permission_ids');

        $role->update($data);
        $role->syncPermissions($permissions);
        $role->refresh();

        return $role;
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}
