<?php

use App\Enums\Currency;
use App\Enums\Language;
use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyElectricity;
use App\Enums\Property\PropertyLivingStyle;
use App\Enums\Property\PropertyOperationalRisk;
use App\Enums\Property\PropertyOrientation;
use App\Enums\Property\PropertyOwnerPriceFlexibility;
use App\Enums\Property\PropertyPowerBackup;
use App\Enums\Property\PropertyRentalType;
use App\Enums\Property\PropertyStatus;
use App\Enums\Property\PropertyTab;
use App\Enums\Property\PropertyTargetProfile;
use App\Enums\Property\PropertyType;
use App\Enums\Property\PropertyWaterSource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Facade;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'aliases' => Facade::defaultAliases()->merge([
        'Currency' => Currency::class,
        'Language' => Language::class,
        'PropertyBedroom' => PropertyBedroom::class,
        'PropertyElectricity' => PropertyElectricity::class,
        'PropertyLivingStyle' => PropertyLivingStyle::class,
        'PropertyOperationalRisk' => PropertyOperationalRisk::class,
        'PropertyOrientation' => PropertyOrientation::class,
        'PropertyPowerBackup' => PropertyPowerBackup::class,
        'PropertyOwnerPriceFlexibility' => PropertyOwnerPriceFlexibility::class,
        'PropertyRentalType' => PropertyRentalType::class,
        'PropertyStatus' => PropertyStatus::class,
        'PropertyTab' => PropertyTab::class,
        'PropertyTargetProfile' => PropertyTargetProfile::class,
        'PropertyType' => PropertyType::class,
        'PropertyWaterSource' => PropertyWaterSource::class,

        'Excel' => Excel::class,
        'Menu' => Menu::class,
        'PDF' => Pdf::class,
        'QrCode' => QrCode::class,

        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
        'role' => RoleMiddleware::class,
    ])->toArray(),

];
