<?php

namespace App\Services;

use App\Libraries\GoHighLevel;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ContactService
{
    public function index(
        ?string $search = null,
        string|int|null $districtId = null,
        string|int|null $areaId = null,
        string|int|null $bedroom = null,
        string|int|null $rentalType = null,
        ?string $startDate = null,
        ?string $endDate = null,
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
        $contacts = Contact::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhereRelation('area.district', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('district', 'name', 'like', "%{$search}%");
                });
            })
            ->when($districtId, fn ($q) => $q->whereRelation('area', 'district_id', $districtId))
            ->when($areaId, fn ($q) => $q->where('area_id', $areaId))
            ->when($bedroom, fn ($q) => $q->where('bedroom', $bedroom))
            ->when($rentalType, fn ($q) => $q->where('rental_type', $rentalType))
            ->when($startDate, fn ($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn ($q) => $q->whereDate('created_at', '<=', $endDate))
            ->when($random, fn ($q) => $q->inRandomOrder())
            ->when($trash, fn ($q) => $q->onlyTrashed())
            ->orderBy($orderBy, $sortBy)
            ->limit($limit);

        if ($first) {
            return $contacts->first();
        }

        if ($count) {
            return $contacts->count();
        }

        if ($paginate) {
            return $contacts->paginate($perPage);
        }

        if ($paginate) {
            return $contacts->paginate($perPage);
        }

        return $contacts->get();
    }

    public function create(array $data = []): Contact
    {
        $table = (new Contact)->getTable();
        DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1");

        try {
            DB::beginTransaction();

            $data['area_id'] = $data['area_id'] ?? null ?: null;
            $data['bedroom'] = $data['bedroom'] ?? null ?: null;
            $data['rental_type'] = $data['rental_type'] ?? null ?: null;

            if (! isset($data['name'])) {
                $data['name'] = trim("{$data['first_name']} {$data['last_name']}");
            }

            if (! isset($data['first_name'])) {
                $data['first_name'] = Str::before($data['name'], ' ');
            }

            if (! isset($data['last_name'])) {
                $data['last_name'] = Str::after($data['name'], ' ');
            }

            $contacts = (new GoHighLevel)->createContacts(data: $data);

            if (! ($contacts['contact']['id'] ?? null)) {
                throw ValidationException::withMessages([
                    'api' => [$contacts['message'] ?? 'Error From Go High Level'],
                ]);
            }

            $data['code'] = $contacts['contact']['id'];

            $contact = Contact::create($data);

            DB::commit();

            return $contact;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Contact::create($data);
    }

    public function update(Contact $contact, array $data = []): Contact
    {
        try {
            DB::beginTransaction();

            if (! isset($data['name'])) {
                $data['name'] = trim("{$data['first_name']} {$data['last_name']}");
            }

            if (! isset($data['first_name'])) {
                $data['first_name'] = Str::before($data['name'], ' ');
            }

            if (! isset($data['last_name'])) {
                $data['last_name'] = Str::after($data['name'], ' ');
            }

            $data['area_id'] = $data['area_id'] ?? null ?: null;
            $data['bedroom'] = $data['bedroom'] ?? null ?: null;
            $data['rental_type'] = $data['rental_type'] ?? null ?: null;

            $contact->update($data);
            $contact->refresh();

            DB::commit();

            return $contact;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $contact;
    }

    public function delete(Contact $contact): bool
    {
        try {
            DB::beginTransaction();

            $contact->delete();

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
