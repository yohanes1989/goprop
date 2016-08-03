<p>Terdapat pendaftaran Agent Referral Listing dengan data sebagai berikut:</p>

<ul>
    <li>Name: {{ $name }}</li>
    <li>Address: {{ $address }}</li>
    <li>Province: {{ AddressHelper::getAddressLabel($province, 'province') }}</li>
    <li>City: {{ AddressHelper::getAddressLabel($city, 'city') }}</li>
    <li>Subdistrict: {{ AddressHelper::getAddressLabel($subdistrict, 'subdistrict') }}</li>
    <li>Phone: {{ $phone }}</li>
    <li>Email: {{ $email }}</li>
</ul>

<p>Silahkan di follow-up.</p>