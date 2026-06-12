<?php

namespace App\Services;

use App\Libraries\GoogleTranslate;
use App\Models\Standard;
use Exception;
use Illuminate\Support\Facades\DB;

class StandardService
{
    public function index(
        ?string $search = null,
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
        $standards = Standard::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('title_id', 'like', "%{$search}%")
                        ->orWhere('title_zh', 'like', "%{$search}%")
                        ->orWhere('title_fr', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('description_id', 'like', "%{$search}%")
                        ->orWhere('description_zh', 'like', "%{$search}%")
                        ->orWhere('description_fr', 'like', "%{$search}%");
                });
            })
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $standards->first();
        }

        if ($count) {
            return $standards->count();
        }

        if ($paginate) {
            return $standards->paginate($perPage);
        }

        if ($paginate) {
            return $standards->paginate($perPage);
        }

        return $standards->get();
    }

    public function create(array $data = []): Standard
    {
        $table = (new Standard)->getTable();
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $standard = Standard::create($data);

            (new GoogleTranslate)->translateModel($standard);

            DB::commit();

            return $standard->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Standard $standard, array $data = []): Standard
    {
        try {
            DB::beginTransaction();

            $standard->update($data);

            (new GoogleTranslate)->translateModel($standard);

            DB::commit();

            return $standard->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Standard $standard): bool
    {
        return $standard->delete();
    }

    public function active(Standard $standard): Standard
    {
        $standard->is_active = ! $standard->is_active;
        $standard->save();
        $standard->refresh();

        return $standard;
    }
}
