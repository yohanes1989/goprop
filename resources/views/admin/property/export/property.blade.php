<html>
<table>
    <tr>
        <th>#</th>
        <th>Property Type</th>
        <th>For Sell</th>
        <th>Sell Package</th>
        <th>For Rent</th>
        <th>Rent Package</th>
        <th>Listing Code</th>
        <th>Status</th>
        <th>Owner</th>
        <th>Owner Phone</th>
        <th>Listing Name</th>
        <th>Address</th>
        <th>Province</th>
        <th>City</th>
        <th>Area</th>
        <th>Building Size</th>
        <th>Building Dimesion</th>
        <th>Land Size</th>
        <th>Land Dimension</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Maid Bedrooms</th>
        <th>Maid Bathrooms</th>
        <th>Furnishing</th>
        <th>Floor</th>
        <th>Carport</th>
        <th>Garage</th>
        <th>Phone Lines</th>
        <th>Electricity</th>
        <th>Certificate</th>
        <th>Orientation</th>
        <th>Agent Listing</th>
        <th>Referral Listing</th>
        <th>Agent Selling</th>
        <th>Referral Selling</th>
        <th>Komisi</th>
    </tr>

    @foreach($properties as $idx=>$property)
        <tr>
            <td>{{ $idx+1 }}</td>
            <td>{{ trans('property.property_type.'.$property->type->slug) }}</td>
            <td>{{ $property->for_sell?'Yes':'' }}</td>
            <td>
                @if($property->for_sell)
                <?php
                $sellPackage = $property->getPackage('sell');
                ?>
                {{ $sellPackage?$sellPackage->name:'' }}
                @endif
            </td>
            <td>{{ $property->for_rent?'Yes':'' }}</td>
            <td>
                @if($property->for_rent)
                <?php
                $rentPackage = $property->getPackage('rent');
                ?>
                {{ $rentPackage?$rentPackage->name:'' }}
                @endif
            </td>
            <td>Listing Code</td>
            <td>{{ \GoProp\Models\Property::getStatusLabel($property->status) }}</td>
            <td>{{ $property->user->profile->singleName }}</td>
            <td>{{ $property->user->profile->mobile_phone_number }}</td>
            <td>{{ $property->property_name }}</td>
            <td>{!! nl2br($property->address) !!}</td>
            <td>{{ $property->province_name }}</td>
            <td>{{ $property->city_name }}</td>
            <td>{{ $property->subdistrict_name }}</td>
            <td>{{ $property->building_size }} m<sup>2</sup></td>
            <td>
                @if($property->building_dimension['length'] && $property->building_dimension['width'])
                    {{ $property->buildingDimensionWithUnit }}
                @endif
            </td>
            <td>{{ $property->land_size }} m<sup>2</sup></td>
            <td>
                @if($property->land_dimension['length'] && $property->land_dimension['width'])
                    {{ $property->landDimensionWithUnit }}
                @endif
            </td>
            <td>{{ $property->rooms }}</td>
            <td>{{ $property->maid_rooms }}</td>
            <td>{{ $property->bathrooms }}</td>
            <td>{{ $property->maid_bathrooms }}</td>
            <td>{{ $property->furnishing }}</td>
            <td>{{ $property->floors+0 }}</td>
            <td>{{ $property->carport_size }}</td>
            <td>{{ $property->garage_size }}</td>
            <td>{{ $property->phone_lines }}</td>
            <td>{{ trans('forms.fields.property.watt', ['electricity' => $property->electricity]) }}</td>
            <td>
                @if($property->certificate)
                {{ trans('property.certificate.'.$property->certificate) }}
                @endif
            </td>
            <td>
                @if($property->orientation)
                {{ \GoProp\Models\Property::getOrientationLabel($property->orientation) }}
                @endif
            </td>
            <td>{{ $property->agentList?$property->agentList->profile->singleName:'' }}</td>
            <td>{{ $property->referralList?$property->referralList->profile->singleName:'' }}</td>
            <td>{{ $property->agentSell?$property->agentSell->profile->singleName:'' }}</td>
            <td>{{ $property->referralSell?$property->referralSell->profile->singleName:'' }}</td>
            <td>Komisi</td>
        </tr>
    @endforeach
</table>

</html>