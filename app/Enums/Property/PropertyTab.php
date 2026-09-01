<?php

namespace App\Enums\Property;

enum PropertyTab: int
{
    case PropertyIndentity = 1;

    case Location = 2;

    case SizeAndSurfaces = 3;

    case BathroomsAndLayout = 4;

    case LegalAndBasicEligibility = 5;

    case EnvironmentAndTranquility = 6;

    case LightAndAcoustics = 7;

    case UtilitiesAndTechnical = 8;

    case DesignLedOrInstagrammable = 9;

    case TradeOffAndTargetProfile = 10;

    case PriceAndInclusions = 11;

    case OwnerAndContact = 12;

    case Images = 13;

    case SaleInformation = 15;

    public function description(): string
    {
        return match ($this) {
            self::PropertyIndentity => trans('property.property_identity'),
            self::Location => trans('property.location'),
            self::SizeAndSurfaces => trans('property.size_and_surfaces'),
            self::BathroomsAndLayout => trans('property.bathrooms_and_layout'),
            self::LegalAndBasicEligibility => trans('property.legal_and_basic_eligibility'),
            self::EnvironmentAndTranquility => trans('property.environment_and_tranquility'),
            self::LightAndAcoustics => trans('property.light_and_acoustics'),
            self::UtilitiesAndTechnical => trans('property.utilities_and_technical'),
            self::DesignLedOrInstagrammable => trans('property.design_led_or_instagrammable'),
            self::TradeOffAndTargetProfile => trans('property.trade_off_and_target_profile'),
            self::PriceAndInclusions => trans('property.price_and_inclusions'),
            self::OwnerAndContact => trans('property.owner_and_contact'),
            self::Images => trans('property.images'),
            self::SaleInformation => trans('property.sale_information'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PropertyIndentity => 'fas fa-building fa-fw',
            self::Location => 'fas fa-location-dot fa-fw',
            self::SizeAndSurfaces => 'fas fa-arrows-up-down-left-right fa-fw',
            self::BathroomsAndLayout => 'fas fa-bath fa-fw',
            self::LegalAndBasicEligibility => 'fas fa-legal fa-fw',
            self::EnvironmentAndTranquility => 'fas fa-tree fa-fw',
            self::LightAndAcoustics => 'fas fa-lightbulb fa-fw',
            self::UtilitiesAndTechnical => 'fas fa-screwdriver-wrench fa-fw',
            self::DesignLedOrInstagrammable => 'fas fa-icons fa-fw',
            self::TradeOffAndTargetProfile => 'fas fa-user-tag fa-fw',
            self::PriceAndInclusions => 'fas fa-money-bill fa-fw',
            self::OwnerAndContact => 'fas fa-address-book fa-fw',
            self::Images => 'fas fa-images fa-fw',
            self::SaleInformation => 'fas fa-cart-shopping fa-fw',
        };
    }
}
