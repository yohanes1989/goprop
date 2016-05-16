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

        return response()->xml($return, 200, [], 'Properties', null, 'Data');
    }

    protected function getPropertyType($type)
    {
        $data = [
            'apartment' => 1,
            'shophouse' => 2,
            'working-space' => 2,
            'condominium' => 3,
            'house' => 4,
            'villa' => 4,
            'industrial' => 5,
            'factory' => 5,
            'warehouse' => 5,
            'beach-resort' => 6,
            'land' => 7,
            'residential-lot' => 12,
            'properties' => 13,
            'island' => 14,
            'retail' => 11,
        ];

        return $data[$type];
    }

    protected function getListingType($type)
    {
        $data = [
            'foreclosure' => 1,
            'rent' => 2,
            'sell' => 3,
            'new-home' => 4
        ];

        return $data[$type];
    }

    protected function getPropertyStatus($status)
    {
        $data = [
            'undefined' => 0,
            Property::STATUS_ACTIVE => 1,
            'offer' => 2,
            'contract' => 3,
            Property::STATUS_INACTIVE => 4,
            Property::STATUS_BLOCKED => 5
        ];

        return $data[$status];
    }

    protected function generatePropertyData($property, $for)
    {
        $propertyData = [
            'Reference_ID' => $property->listing_code,
            'PropertyTitle' => $property->property_name,
            'BuildingName' => null,
            'Area' => !empty(intval($property->building_size))?$property->building_size:$property->land_size,
            'LotSize' => $property->garage_size + $property->carport_size,
            'PropertyPrice' => $property->getPrice('sell'),
            'Bedrooms' => $property->rooms,
            'Bathrooms' => $property->bathrooms,
            'ListingType' => ($for == 'sell')?$this->getListingType('sell'):$this->getListingType('rent')*12,
            'City' => $property->city_name,
            'PropertyDesc' => '<![CDATA['.nl2br($property->description).']]>',
            'PropertyType' => $this->getPropertyType($property->type->slug),
            'PropertyStatus' => $this->getPropertyStatus($property->status),
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