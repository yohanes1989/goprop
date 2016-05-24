<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Property;
use GoProp\Facades\AddressHelper;

class PortalController extends Controller
{
    public function getXMLLamudi()
    {
        $return = [];

        $qb = Property::active();
        AddressHelper::addAddressQueryScope($qb);

        //By exclusive
        $qb->selectRaw('properties.*, IF(Pac.slug = \'exclusive\', 1, 0) as is_exclusive');
        $qb->leftJoin('package_property AS PP', 'PP.property_id', '=', 'properties.id')
            ->leftJoin('packages AS Pac', 'PP.package_id', '=', 'Pac.id')
            ->leftJoin('package_categories AS PC', 'PC.id', '=', 'Pac.package_category_id');

        $qb->groupBy('properties.id');

        $qb->orderBy('is_exclusive', 'DESC');

        $sellProperties = $qb->where('for_sell', 1)->get();

        foreach($sellProperties as $property){
            if($property->hasThumbnail() || $property->hasFloorplan()){
                $propertyData = $this->generatePropertyData($property, 'sell');

                $return[] = $propertyData;
            }
        }

        $rentProperties = $qb->where('for_rent', 1)->get();

        foreach($rentProperties as $property){
            if($property->hasThumbnail() || $property->hasFloorplan()){
                $propertyData = $this->generatePropertyData($property, 'rent');

                $return[] = $propertyData;
            }
        }

        return response()->xml($return, 200, [], 'Properties', null, 'Data');
    }

    protected function getPropertyType($type)
    {
        $data = [
            'apartment' => 'Apartment',
            'shophouse' => 'Commercial',
            'working-space' => 'Commercial',
            'condominium' => 'Condo',
            'house' => 'House',
            'villa' => 'House',
            'industrial' => 'Industrial',
            'factory' => 'Industrial',
            'warehouse' => 'Industrial',
            'beach-resort' => 'Beach Resort (Private)',
            'land' => 'Land',
            'residential-lot' => 'Residential Lot',
            'properties' => 'Properties',
            'island' => 'Island',
            'retail' => 'Retail',
        ];

        return $data[$type];
    }

    protected function getListingType($type)
    {
        $data = [
            'foreclosure' => 1,
            'rent' => 'rent',
            'sell' => 'buy',
            'new-home' => 4
        ];

        return $data[$type];
    }

    protected function getPropertyStatus($status)
    {
        $data = [
            'undefined' => 'inactive',
            Property::STATUS_ACTIVE => 'active',
            'offer' => 'active',
            'contract' => 'inactive',
            Property::STATUS_INACTIVE => 'inactive',
            Property::STATUS_BLOCKED => 'inactive'
        ];

        return $data[$status];
    }

    protected function getFurnishing($furnishing)
    {
        $data = [
            Property::FURNISHING_FURNISHED => 'yes',
            Property::FURNISHING_PART_FURNISHED => 'semi',
            Property::FURNISHING_UNFURNISHED => 'no',
        ];

        return $data[$furnishing];
    }

    protected function generatePropertyData($property, $for)
    {
        $propertyData = [
            'Reference_ID' => $property->listing_code,
            'PropertyTitle' => $property->property_name,
            'BuildingName' => null,
            'BuildingSize' => !empty(intval($property->building_size))?$property->building_size:$property->building_size,
            'LandSize' => !empty(intval($property->land_size))?$property->land_size:$property->land_size,
            'PropertyPrice' => ($for == 'sell')?$property->getPrice('sell'):$property->getPrice('rent')*12,
            'Bedrooms' => $property->rooms,
            'Bathrooms' => $property->bathrooms,
            'OfferType' => ($for == 'sell')?$this->getListingType('sell'):$this->getListingType('rent'),
            'ListingRegion' => $property->province_name,
            'ListingCity' => $property->city_name,
            'PropertyDesc' => '<![CDATA['.nl2br($property->description).']]>',
            'PropertyType' => $this->getPropertyType($property->type->slug),
            'PropertyStatus' => $this->getPropertyStatus($property->status),
            'Floor' => $property->floors,
            'Furnished' => $this->getFurnishing($property->furnishing),
            'ContactPerson' => [
                'listingFirstName' => 'GoProp',
                'listingLastName' => 'Indonesia',
                'listingContact1' => config('app.contact_number'),
                'listingContact2' => null,
                'listingEmail' => config('app.contact_from_email'),
                'listingAgentLicence' => 0,
            ],
        ];

        foreach($property->photos as $photo){
            $propertyData['photos'][] = [
                'PhotoPath' => url('images/original/'.$photo->filename)
            ];
        }

        foreach($property->floorplans as $floorplan){
            $propertyData['photos'][] = [
                'PhotoPath' => url('images/original/'.$floorplan->filename)
            ];
        }

        return $propertyData;
    }
}