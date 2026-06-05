<?php

namespace App\Services;

use App\Libraries\GoogleDrive;
use App\Libraries\GoogleTranslate;
use App\Models\Guide;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class GuideService
{
    public function index(
        ?string $search = null,
        string|int|null $guideCategoryId = null,
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
        $guides = Guide::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('title_id', 'like', "%{$search}%")
                        ->orWhere('title_zh', 'like', "%{$search}%")
                        ->orWhere('title_fr', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('body_id', 'like', "%{$search}%")
                        ->orWhere('body_zh', 'like', "%{$search}%")
                        ->orWhere('body_fr', 'like', "%{$search}%")
                        ->orWhereRelation('category', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('category', 'name_id', 'like', "%{$search}%")
                        ->orWhereRelation('category', 'name_zh', 'like', "%{$search}%")
                        ->orWhereRelation('category', 'name_fr', 'like', "%{$search}%");
                });
            })
            ->when($guideCategoryId, fn ($q) => $q->where('guide_category_id', $guideCategoryId))
            ->when($isShow, fn ($q) => $q->whereIn('is_show', $isShow))
            ->when($isActive, fn ($q) => $q->whereIn('is_active', $isActive))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $guides->first();
        }

        if ($count) {
            return $guides->count();
        }

        if ($paginate) {
            return $guides->paginate($perPage);
        }

        if ($paginate) {
            return $guides->paginate($perPage);
        }

        return $guides->get();
    }

    public function create(array $data = []): Guide
    {
        $table = (new Guide)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $image = $data['image'];

            Arr::pull($data, 'image');

            $guide = Guide::create($data);

            (new GoogleTranslate)->translateModel($guide);

            if ($image) {
                $this->uploadImage(guide: $guide, fileId: $image);
            }

            DB::commit();

            return $guide;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Guide $guide, array $data = []): Guide
    {
        try {
            DB::beginTransaction();

            if ($data['image']) {
                $this->uploadImage(guide: $guide, fileId: $data['image']);
            }

            Arr::pull($data, 'image');

            $guide->update($data);

            (new GoogleTranslate)->translateModel($guide);

            DB::commit();

            return $guide->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Guide $guide): bool
    {
        try {
            DB::beginTransaction();

            $guide->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Guide $guide): Guide
    {
        $guide->is_show = ! $guide->is_show;
        $guide->save();
        $guide->refresh();

        return $guide;
    }

    public function active(Guide $guide): Guide
    {
        $guide->is_active = ! $guide->is_active;
        $guide->save();
        $guide->refresh();

        return $guide;
    }

    public function latest(): ?Guide
    {
        return Guide::latest()->show()->active()->first();
    }

    public function detail(string $slug): ?Guide
    {
        return Guide::where('slug', $slug)->show()->active()->first();
    }

    public function uploadImage(Guide $guide, array $fileId): Guide
    {
        $google = new GoogleDrive;

        $directory = 'images/guide';
        $baseUrl = request()->getSchemeAndHttpHost();

        $assetPath = config('constants.assets.path').'/'.$directory;
        $assetUrl = config('constants.assets.url');

        $fullUrl = "{$baseUrl}{$assetUrl}";

        $content = $google->download($fileId[0]['id']);

        try {
            $image = Image::make($content);

            // $image->resize(1200, null, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // });

            $fileName = "{$guide->slug}.webp";
            $fullPath = "{$assetPath}/{$fileName}";

            $encoded = (string) $image->encode('webp', 70);
            file_put_contents($fullPath, $encoded);

            $guide->google_file_id = $fileId[0]['id'];
            $guide->image_url = "{$fullUrl}/{$directory}/{$fileName}";
            $guide->save();

            return $guide;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
