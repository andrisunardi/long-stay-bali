<?php

namespace App\Services;

use App\Models\Area;
use Exception;
use Illuminate\Support\Facades\DB;

class AreaService
{
    public function index(
        ?string $search = null,
        string|int|null $districtId = null,
        array $isPromoted = [],
        array $isShow = [],
        array $isActive = [],
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
        $areas = Area::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereRelation('district', 'name', 'like', "%{$search}%");
                });
            })
            ->when($districtId, fn ($q) => $q->where('district_id', $districtId))
            ->when($isPromoted, fn ($q) => $q->whereIn('is_promoted', $isPromoted))
            ->when($isShow, fn ($q) => $q->whereIn('is_show', $isShow))
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $areas->first();
        }

        if ($count) {
            return $areas->count();
        }

        if ($paginate) {
            return $areas->paginate($perPage);
        }

        if ($paginate) {
            return $areas->paginate($perPage);
        }

        return $areas->get();
    }

    public function create(array $data = []): Area
    {
        $table = (new Area)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $area = Area::create($data);

            DB::commit();

            return $area;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Area $area, array $data = []): Area
    {
        try {
            DB::beginTransaction();

            $area->update($data);
            $area->refresh();

            DB::commit();

            return $area;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Area $area): bool
    {
        try {
            DB::beginTransaction();

            $area->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function promoted(Area $area): Area
    {
        $area->is_promoted = ! $area->is_promoted;
        $area->save();
        $area->refresh();

        return $area;
    }

    public function show(Area $area): Area
    {
        $area->is_show = ! $area->is_show;
        $area->save();
        $area->refresh();

        return $area;
    }

    public function active(Area $area): Area
    {
        $area->is_active = ! $area->is_active;
        $area->save();
        $area->refresh();

        return $area;
    }
}
