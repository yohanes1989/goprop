<p>Dear Admin,</p>

<p>Referral Agent {{ $referralInformation->user->profile->singleName }} baru saja mereferensikan properti baru dengan detil berikut:</p>

<ul>
    <li>Referral Agent: {{ $referralInformation->user->profile->singleName }}</li>
    <li>Owner Name: {{ $referralInformation->name }}</li>
    <li>Phone: {{ $referralInformation->contact_number.(!empty($referralInformation->other_contact_number)?', '.$referralInformation->other_contact_number:'') }}<br/>{{ $referralInformation->email }}</li>
    <li>Alamat: {!! nl2br($referralInformation->address) !!}</li>
</ul>

<p>Untuk lebih detail, silahkan periksa dari Backend pada menu <strong>Referral Informations</strong></p>