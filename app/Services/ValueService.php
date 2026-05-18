<?php

namespace App\Services;

use App\Libraries\GoogleTranslate;
use App\Models\Value;
use Exception;
use Illuminate\Support\Facades\DB;

class ValueService
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
        $values = Value::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('title_id', 'like', "%{$search}%")
                        ->orWhere('title_zh', 'like', "%{$search}%")
                        ->orWhere('title_fr', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('short_description_id', 'like', "%{$search}%")
                        ->orWhere('short_description_zh', 'like', "%{$search}%")
                        ->orWhere('short_description_fr', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('description_id', 'like', "%{$search}%")
                        ->orWhere('description_zh', 'like', "%{$search}%")
                        ->orWhere('description_fr', 'like', "%{$search}%")
                        ->orWhere('icon', 'like', "%{$search}%");
                });
            })
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $values->first();
        }

        if ($count) {
            return $values->count();
        }

        if ($paginate) {
            return $values->paginate($perPage);
        }

        if ($paginate) {
            return $values->paginate($perPage);
        }

        return $values->get();
    }

    public function create(array $data = []): Value
    {
        $table = (new Value)->getTable();
        DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $value = Value::create($data);

            (new GoogleTranslate)->translateModel($value);

            DB::commit();

            return $value->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Value $value, array $data = []): Value
    {
        try {
            DB::beginTransaction();

            $value->update($data);

            (new GoogleTranslate)->translateModel($value);

            return $value->refresh();

            DB::commit();

            return $property->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Value $value): bool
    {
        return $value->delete();
    }

    public function active(Value $value): Value
    {
        $value->is_active = ! $value->is_active;
        $value->save();
        $value->refresh();

        return $value;
    }
}
