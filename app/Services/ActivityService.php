<?php

namespace App\Services;

use Spatie\Activitylog\Models\Activity;

class ActivityService
{
    public function index(
        ?string $search = '',
        ?string $event = '',
        ?string $subjectType = '',
        ?string $subjectId = '',
        int|string|null $causerId = null,
        ?string $date = '',
        bool $random = false,
        string $orderBy = 'id',
        string $sortBy = 'desc',
        int|string|null $limit = null,
        bool $first = false,
        bool $count = false,
        bool $paginate = true,
        int $perPage = 10,
    ): object|int|null {
        $activities = Activity::query()
            ->when($search, fn ($q) => $q->where(function ($query) use ($search) {
                $query->where('log_name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('event', 'LIKE', "%{$search}%")
                    ->orWhere('subject_type', 'LIKE', "%{$search}%")
                    ->orWhere('subject_id', 'LIKE', "%{$search}%")
                    ->orWhere('causer_type', 'LIKE', "%{$search}%")
                    ->orWhere('causer_id', 'LIKE', "%{$search}%")
                    ->orWhere('properties', 'LIKE', "%{$search}%")
                    ->orWhere('batch_uuid', 'LIKE', "%{$search}%");
            }))
            ->when($event, fn ($q) => $q->where('event', $event))
            ->when($subjectType, fn ($q) => $q->where('subject_type', $subjectType))
            ->when($subjectId, fn ($q) => $q->where('subject_id', $subjectId))
            ->when($causerId, fn ($q) => $q->where('causer_id', $causerId))
            ->when($date, fn ($q) => $q->whereDate('created_at', $date))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $activities->first();
        }

        if ($count) {
            return $activities->count();
        }

        if ($paginate) {
            return $activities->paginate($perPage);
        }

        return $activities->get();
    }
}
