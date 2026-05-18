<?php

namespace App\Services;

use App\Libraries\GoogleTranslate;
use App\Models\GuideCategory;
use Illuminate\Support\Facades\DB;

class GuideCategoryService
{
    public function index(
        ?string $search = null,
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
        $guideCategories = GuideCategory::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('name_id', 'like', "%{$search}%")
                        ->orWhere('name_zh', 'like', "%{$search}%")
                        ->orWhere('name_fr', 'like', "%{$search}%");
                });
            })
            ->when($isShow, fn ($q) => $q->whereIn('is_show', $isShow))
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $guideCategories->first();
        }

        if ($count) {
            return $guideCategories->count();
        }

        if ($paginate) {
            return $guideCategories->paginate($perPage);
        }

        if ($paginate) {
            return $guideCategories->paginate($perPage);
        }

        return $guideCategories->get();
    }

    public function create(array $data = []): GuideCategory
    {
        $table = (new GuideCategory)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        $guideCategory = GuideCategory::create($data);

        (new GoogleTranslate)->translateModel($guideCategory);

        return $guideCategory;
    }

    public function update(GuideCategory $guideCategory, array $data = []): GuideCategory
    {
        $guideCategory->update($data);

        (new GoogleTranslate)->translateModel($guideCategory);

        return $guideCategory->refresh();
    }

    public function delete(GuideCategory $guideCategory): bool
    {
        return $guideCategory->delete();
    }

    public function show(GuideCategory $guideCategory): GuideCategory
    {
        $guideCategory->is_show = ! $guideCategory->is_show;
        $guideCategory->save();
        $guideCategory->refresh();

        return $guideCategory;
    }

    public function active(GuideCategory $guideCategory): GuideCategory
    {
        $guideCategory->is_active = ! $guideCategory->is_active;
        $guideCategory->save();
        $guideCategory->refresh();

        return $guideCategory;
    }
}
