<?php
$isAdmin = \Illuminate\Support\Facades\Auth::user()->is('administrator');
?>

@if(!$isAdmin)
    <p class="well">
        Apabila kamu memiliki pertanyaan, jangan segan untuk menghubungi kami di <a href="tel:{{ config('app.contact_number') }}">{{ config('app.contact_number') }}</a> atau <a href="mailto:marketing@goprop.co.id">marketing@goprop.co.id</a>.<br/>
        <strong>Kami akan segera merespon pada jam kerja.</strong>
    </p>
@endif