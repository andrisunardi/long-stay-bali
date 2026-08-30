<?php

namespace App\Services;

use App\Enums\Property\PropertyOwnershipType;
use App\Enums\Property\PropertyRentalType;
use App\Enums\Property\PropertyStatus;
use App\Libraries\GoogleDrive;
use App\Libraries\GoogleMapsUrlParser;
use App\Models\Property;
use App\Models\PropertyImage;
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
        array $districts = [],
        array $areas = [],
        ?int $yearBuilt = null,
        ?string $completionDate = null,
        ?string $bedroom = null,
        array $bedrooms = [],
        ?string $livingStyle = null,
        ?string $rentalType = null,
        array $rentalTypes = [],
        ?string $listingType = null,
        array $listingTypes = [],
        ?string $currency = null,
        array $currencies = [],
        ?string $ownershipType = null,
        array $ownershipTypes = [],
        ?string $leaseExpiryDate = null,
        ?string $leaseExtensionAvailable = null,
        array $leaseExtensionAvailables = [],
        ?string $type = null,
        array $types = [],
        ?string $status = null,
        array $statuses = [],
        ?string $startDate = null,
        ?string $endDate = null,
        // array $availabilityDates = [],
        array $prices = [],
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
                        ->orWhere('year_built', 'like', "%{$search}%")
                        ->orWhere('villa_name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('lease_extension_terms_or_price', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'phone', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'email', 'like', "%{$search}%");
                });
            })
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->when($districtId, fn ($q) => $q->where('district_id', $districtId))
            ->when($areaId, fn ($q) => $q->where('area_id', $areaId))
            // ->when($districts, fn ($q) => $q->whereIn('district_id', $districts))
            // ->when($areas, fn ($q) => $q->whereIn('area_id', $areas))
            ->when($districts || $areas, function ($q) use ($districts, $areas) {
                $q->where(function ($query) use ($districts, $areas) {
                    if (! empty($districts)) {
                        $query->whereIn('district_id', $districts);
                    }
                    if (! empty($areas)) {
                        $method = ! empty($districts) ? 'orWhereIn' : 'whereIn';
                        $query->{$method}('area_id', $areas);
                    }
                });
            })
            ->when($yearBuilt, fn ($q) => $q->where('year_built', $yearBuilt))
            ->when($completionDate, fn ($q) => $q->whereDate('completion_date', $completionDate))
            ->when($bedroom, fn ($q) => $q->where('bedroom', $bedroom))
            ->when($bedrooms, fn ($q) => $q->whereIn('bedroom', $bedrooms))
            ->when($livingStyle, fn ($q) => $q->where('living_style', $livingStyle))
            ->when($rentalType, fn ($q) => $q->where('rental_type', $rentalType))
            ->when($rentalTypes, fn ($q) => $q->whereIn('rental_type', $rentalTypes))
            ->when($listingType, fn ($q) => $q->where('listing_type', $listingType))
            ->when($listingTypes, fn ($q) => $q->whereIn('listing_type', $listingTypes))
            ->when($currency, fn ($q) => $q->where('currency', $currency))
            ->when($currencies, fn ($q) => $q->whereIn('currency', $currencies))
            ->when($ownershipType, fn ($q) => $q->where('ownership_type', $ownershipType))
            ->when($ownershipTypes, fn ($q) => $q->whereIn('ownership_type', $ownershipTypes))
            ->when($leaseExpiryDate, fn ($q) => $q->whereDate('lease_expiry_date', $leaseExpiryDate))
            ->when($leaseExtensionAvailable, fn ($q) => $q->where('lease_extension_available', $leaseExtensionAvailable))
            ->when($leaseExtensionAvailables, fn ($q) => $q->whereIn('lease_extension_available', $leaseExtensionAvailables))
            ->when($type, fn ($q) => $q->where('type', $type))
            ->when($types, fn ($q) => $q->whereIn('type', $types))
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
            ->when(
                $rentalType == PropertyRentalType::Monthly->value &&
                    isset($prices['min']) && isset($prices['max']),
                fn ($q) => $q->whereBetween('monthly_price', [
                    $prices['min'],
                    $prices['max'],
                ])
            )
            ->when(
                $rentalType == PropertyRentalType::Yearly->value &&
                    isset($prices['min']) && isset($prices['max']),
                fn ($q) => $q->whereBetween('yearly_price', [
                    $prices['min'],
                    (string) $prices['max'],
                ])
            )
            ->when(
                $rentalType == PropertyRentalType::Both->value &&
                    isset($prices['min']) && isset($prices['max']),
                fn ($q) => $q->where(function ($query) use ($prices) {
                    $query->whereBetween('monthly_price', [
                        $prices['min'],
                        $prices['max'],
                    ])->orWhereBetween('yearly_price', [
                        $prices['min'] * 12,
                        $prices['max'] * 12,
                    ]);
                })
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
            $data['completion_date'] = $data['completion_date'] ?: null;
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

            if ($data['google_maps_url']) {
                $result = GoogleMapsUrlParser::parse(url: $data['google_maps_url']);

                $data['latitude'] = $result['latitude'];
                $data['longitude'] = $result['longitude'];

                if (blank($data['address'])) {
                    $data['address'] = $result['address'];
                }
            }

            if (! in_array($data['status'], [PropertyStatus::UnderConstruction->value, PropertyStatus::OffPlan->value])) {
                $data['completion_date'] = null;
            }

            Arr::pull($data, 'images');
            Arr::pull($data, 'internet_speedtest_image');

            $property = Property::create($data);

            // (new GoogleTranslate)->translateModel($property);

            if (! empty($images)) {
                $this->uploadImages(property: $property, images: $images);
            }

            if ($data['owner_id']) {
                (new ContactService)->owner(contact: $property->owner);
            }

            if ($data['owner_representative_id']) {
                (new ContactService)->ownerRepresentative(contact: $property->ownerRepresentative);
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
            $data['completion_date'] = $data['completion_date'] ?: null;
            $data['latitude'] = $data['latitude'] ?: null;
            $data['longitude'] = $data['longitude'] ?: null;

            $data['slug'] = Str::slug($data['name']);

            if ($data['google_maps_url']) {
                $result = GoogleMapsUrlParser::parse(url: $data['google_maps_url']);

                $data['latitude'] = $result['latitude'];
                $data['longitude'] = $result['longitude'];

                if (blank($data['address'])) {
                    $data['address'] = $result['address'];
                }
            }

            if ($data['ownership_type'] != PropertyOwnershipType::Leasehold->value) {
                $data['lease_expiry_date'] = null;
                $data['lease_extension_available'] = null;
                $data['lease_extension_terms_or_price'] = null;
            }

            if (! in_array($data['status'], [PropertyStatus::UnderConstruction->value, PropertyStatus::OffPlan->value])) {
                $data['completion_date'] = null;
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

            $this->uploadImages(property: $property, images: $data['images']);

            Arr::pull($data, 'images');
            Arr::pull($data, 'internet_speedtest_image');

            $property->update($data);

            // (new GoogleTranslate)->translateModel($property);

            if ($data['owner_id']) {
                (new ContactService)->owner(contact: $property->owner);
            }

            if ($data['owner_representative_id']) {
                (new ContactService)->ownerRepresentative(contact: $property->ownerRepresentative);
            }

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

            $propertyImage->update(['position' => null]);
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

                // $image->resize(1200, null, function ($constraint) {
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });

                $id = PropertyImage::max('id') + 1;

                $fileName = "{$property->slug}-{$id}-{$position}.webp";
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

    public function counter(Property $property): int
    {
        return $property->increment('counter');
    }
}
