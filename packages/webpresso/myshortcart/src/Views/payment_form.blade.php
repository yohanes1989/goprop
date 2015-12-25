<form id="myshortcart-form" method="POST" action="{{ $submit_url }}" >
    <input type=hidden name="BASKET" value="{{ $basket }}">
    <input type=hidden name="STOREID" value="{{ $store_id }}">
    <input type=hidden name="TRANSIDMERCHANT" value="{{ $msc_transaction_id }}">
    <input type=hidden name="AMOUNT" value="{{ $amount }}">
    <input type=hidden name="URL" value="{{ $url }}">
    <input type=hidden name="WORDS" value="{{ $words }}">
    <input type=hidden name="CNAME" value="{{ $customer_name }}">
    <input type=hidden name="CEMAIL" value="{{ $customer_email }}">
    <input type=hidden name="CWPHONE" value="{{ $customer_phone }}">
    <input type=hidden name="CHPHONE" value="{{ $customer_work_phone }}">
    <input type=hidden name="CMPHONE" value="{{ $customer_mobile_phone }}">
    <input type=hidden name="CADDRESS" value="{{ $customer_address }}">
    <input type=hidden name="CZIPCODE" value="{{ $customer_postal_code }}">
    <input type=hidden name="CCITY" value="{{ $customer_city }}">
    <input type=hidden name="CSTATE" value="{{ $customer_state }}">
    <input type=hidden name="CCOUNTRY" value="{{ $customer_country }}">
    <input type=hidden name="BIRTHDATE" value="{{ $customer_birthday }}">
    <input type=hidden name="SADDRESS" value="{{ $shipping_address }}">
    <input type=hidden name="SZIPCODE" value="{{ $shipping_postal_code }}">
    <input type=hidden name="SCITY" value="{{ $shipping_city }}">
    <input type=hidden name="SSTATE" value="{{ $shipping_state }}">
    <input type=hidden name="SCOUNTRY" value="{{ $shipping_country }}">
</form>

<script type="text/javascript">
    document.getElementById('myshortcart-form').submit();
</script>