<?php

namespace App\Services;

use App\Enums\Property\PropertyStatus;
use App\Libraries\GoogleDrive;
use App\Libraries\GoogleTranslate;
use App\Models\Property;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PropertyService
{
    public function index(
        ?string $search = null,
        ?string $userId = null,
        ?string $districtId = null,
        ?string $areaId = null,
        ?string $bedroom = null,
        array $bedrooms = [],
        ?string $livingStyle = null,
        ?string $status = null,
        array $statuses = [],
        ?string $startDate = null,
        ?string $endDate = null,
        // array $availabilityDates = [],
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
        $properties = Property::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('description_id', 'like', "%{$search}%")
                        ->orWhere('description_zh', 'like', "%{$search}%")
                        ->orWhere('description_fr', 'like', "%{$search}%")
                        ->orWhere('villa_name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'phone', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'email', 'like', "%{$search}%");
                });
            })
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->when($districtId, fn ($q) => $q->where('district_id', $districtId))
            ->when($areaId, fn ($q) => $q->where('area_id', $areaId))
            ->when($bedroom, fn ($q) => $q->where('bedroom', $bedroom))
            ->when($bedrooms, fn ($q) => $q->whereIn('bedroom', $bedrooms))
            ->when($livingStyle, fn ($q) => $q->where('living_style', $livingStyle))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($statuses, fn ($q) => $q->whereIn('status', $statuses))
            // ->when($startDate, fn($q) => $q->whereDate('availability_date', '>=', $startDate))
            // ->when($endDate, fn($q) => $q->whereDate('availability_date', '<=', $endDate))
            // ->when($availabilityDates, fn($q) => $q->whereBetween('availability_date', $availabilityDates))
            ->when(
                $startDate == today()->toDateString() && $endDate == today()->toDateString(),
                function ($query) {
                    $query
                        ->whereDate('availability_date', '<=', today()->addMonths(3)->toDateString());
                }
            )
            ->when(
                $startDate && $startDate != today()->toDateString(),
                fn ($query) => $query->whereDate('availability_date', '>=', $startDate)
            )
            ->when(
                $endDate && $endDate != today()->toDateString(),
                fn ($query) => $query->whereDate('availability_date', '<=', $endDate)
            )
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $properties->first();
        }

        if ($count) {
            return $properties->count();
        }

        if ($paginate) {
            return $properties->paginate($perPage);
        }

        if ($paginate) {
            return $properties->paginate($perPage);
        }

        return $properties->get();
    }

    public function create(array $data = []): Property
    {
        $table = (new Property)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $images = $data['images'];

            $data['availability_date'] = $data['availability_date'] ?: null;
            $data['visit_date'] = $data['visit_date'] ?: null;
            $data['latitude'] = $data['latitude'] ?: null;
            $data['longitude'] = $data['longitude'] ?: null;

            $data['slug'] = Str::slug($data['name']);

            // $data['folder_id'] = (new GoogleDrive)->createFolder(
            //     name: $data['code'],
            //     parentId: config('constants.folder_id.property'),
            // );

            // if ($data['internet_speedtest_image'] ?? null) {
            //     $data['internet_speedtest_image_path'] = (new GoogleDrive)->uploadImage(
            //         image: $data['internet_speedtest_image'],
            //         name: 'internet-speedtest',
            //         folderId: $data['folder_id'],
            //     );
            // }

            if (! empty($data['google_maps_url'])) {
                $response = Http::withOptions([
                    'allow_redirects' => true,
                ])->get($data['google_maps_url']);

                $finalUrl = $response->effectiveUri()?->__toString();

                if ($finalUrl) {
                    preg_match(
                        '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
                        $finalUrl,
                        $coordinates,
                    );

                    $data['latitude'] = $coordinates[1] ?? null;
                    $data['longitude'] = $coordinates[2] ?? null;

                    preg_match('/place\/([^\/]+)/', $finalUrl, $place);

                    if (! $data['address']) {
                        $data['address'] = isset($place[1])
                            ? urldecode(str_replace('+', ' ', $place[1]))
                            : null;
                    }
                }
            }

            Arr::pull($data, 'images');
            Arr::pull($data, 'internet_speedtest_image');

            $property = Property::create($data);

            (new GoogleTranslate)->translateModel($property);

            if (! empty($images)) {
                $this->uploadImages(property: $property, images: $images);
            }

            DB::commit();

            return $property->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Property $property, array $data = []): Property
    {
        try {
            DB::beginTransaction();

            $data['availability_date'] = $data['availability_date'] ?: null;
            $data['visit_date'] = $data['visit_date'] ?: null;
            $data['latitude'] = $data['latitude'] ?: null;
            $data['longitude'] = $data['longitude'] ?: null;

            $data['slug'] = Str::slug($data['name']);

            if (! empty($data['google_maps_url'])) {
                $response = Http::withOptions([
                    'allow_redirects' => true,
                ])->get($data['google_maps_url']);

                $finalUrl = $response->effectiveUri()?->__toString();

                if ($finalUrl) {
                    preg_match(
                        '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
                        $finalUrl,
                        $coordinates,
                    );

                    $data['latitude'] = $coordinates[1] ?? null;
                    $data['longitude'] = $coordinates[2] ?? null;

                    preg_match('/place\/([^\/]+)/', $finalUrl, $place);

                    if (! $data['address']) {
                        $data['address'] = isset($place[1])
                            ? urldecode(str_replace('+', ' ', $place[1]))
                            : null;
                    }
                }
            }

            // if ($property->code != $data['code']) {
            //     $data['folder_id'] = (new GoogleDrive)->renameFolder(
            //         folderId: $property->folder_id,
            //         name: $data['code'],
            //     );
            // }

            // if ($data['image'] ?? null) {
            //     $data['image_path'] = (new GoogleDrive)->uploadImage(
            //         image: $data['image'],
            //         name: 'cover',
            //         folderId: $property->folder_id,
            //     );

            //     if ($property->image_path) {
            //         (new GoogleDrive)->delete($property->image_path);
            //     }
            // }

            // if ($data['internet_speedtest_image'] ?? null) {
            //     $data['internet_speedtest_image_path'] = (new GoogleDrive)->uploadImage(
            //         image: $data['internet_speedtest_image'],
            //         name: 'internet-speedtest',
            //         folderId: $property->folder_id,
            //     );

            //     if ($property->internet_speedtest_image_path) {
            //         (new GoogleDrive)->delete($property->internet_speedtest_image_path);
            //     }
            // }

            if (! empty($data['images'])) {
                $this->uploadImages(property: $property, images: $data['images']);
            }

            Arr::pull($data, 'images');
            Arr::pull($data, 'internet_speedtest_image');

            $property->update($data);

            (new GoogleTranslate)->translateModel($property);

            DB::commit();

            return $property->refresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Property $property): bool
    {
        // if ($property->folder_id) {
        //     (new GoogleDrive)->delete(fileId: $property->folder_id);
        // }

        return $property->delete();
    }

    public function detail(string $slug): ?Property
    {
        $statuses = [PropertyStatus::AcceptUpper->value, PropertyStatus::AcceptPremium->value];

        return Property::query()
            ->whereIn('status', $statuses)
            ->where('slug', $slug)
            ->first();
    }

    public function uploadImages(Property $property, array $images = []): void
    {
        $google = new GoogleDrive;

        $directory = 'images/property';
        $baseUrl = request()->getSchemeAndHttpHost();

        $assetPath = config('constants.assets.path').'/'.$directory;
        $assetUrl = config('constants.assets.url');

        $fullUrl = "{$baseUrl}{$assetUrl}";

        $imageUrls = collect($images)->pluck('thumbnail');
        $propertyImages = $property->images()
            ->whereNotIn('image_url', $imageUrls)
            ->get();

        foreach ($propertyImages as $propertyImage) {
            if (file_exists(public_path(
                str_replace($baseUrl, '', $propertyImage->image_url)
            ))) {
                unlink(public_path(
                    str_replace($baseUrl, '', $propertyImage->image_url)
                ));
            }

            $propertyImage->delete();
        }

        foreach ($images as $key => $file) {
            $position = $key + 1;

            if ($file['type'] === 'url') {
                $existingImage = $property
                    ->images()
                    ->where('image_url', $file['thumbnail'])
                    ->first();

                if ($existingImage) {
                    $existingImage->update(['position' => $position]);
                }

                continue;
            }

            $existingImage = $property
                ->images()
                ->where('google_file_id', $file['id'])
                ->first();

            if ($existingImage) {
                $existingImage->update(['position' => $position]);

                continue;
            }

            try {
                $content = $google->download($file['id']);

                $image = Image::make($content);

                $image->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $fileName = "{$property->slug}-{$position}.webp";
                $fullPath = "{$assetPath}/{$fileName}";

                $encoded = (string) $image->encode('webp', 70);

                file_put_contents($fullPath, $encoded);

                $property->images()->create([
                    'name' => $file['name'],
                    'image_url' => "{$fullUrl}/{$directory}/{$fileName}",
                    'google_file_id' => $file['id'],
                    'position' => $position,
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    public function list(array $data = []): Property
    {
        $form = [];
        $form['name'] = $data['name'];
        $form['email'] = $data['email'];
        $form['phone'] = $data['phone'];

        $contact = (new ContactService)->create(data: $form);

        $id = Property::max('id') + 1;
        $name = $data['name'];

        $data = [];
        $data['code'] = "LYP{$id}";
        $data['name'] = "Property {$name}";
        $data['owner_id'] = $contact->id;
        $data['images'] = [];
        $data['availability_date'] = null;
        $data['visit_date'] = null;
        $data['latitude'] = null;
        $data['longitude'] = null;

        if (! empty($data['google_maps_url'])) {
            $response = Http::withOptions([
                'allow_redirects' => true,
            ])->get($data['google_maps_url']);

            $finalUrl = $response->effectiveUri()?->__toString();

            if ($finalUrl) {
                preg_match(
                    '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
                    $finalUrl,
                    $coordinates,
                );

                $data['latitude'] = $coordinates[1] ?? null;
                $data['longitude'] = $coordinates[2] ?? null;

                preg_match('/place\/([^\/]+)/', $finalUrl, $place);

                if (! $data['address']) {
                    $data['address'] = isset($place[1])
                        ? urldecode(str_replace('+', ' ', $place[1]))
                        : null;
                }
            }
        }

        $property = (new PropertyService)->create(data: $data);

        return $property;
    }
}
