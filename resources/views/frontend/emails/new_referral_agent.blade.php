@extends('emails.master')

@section('email_title', 'Welcome Referral Agent!')

@section('content')
    <p class="lead" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Selamat bergabung {{ $user->profile->singleName }}<br/>
        Kamu telah terdaftar sebagai Referral Agent dari GoProp!</p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
        Berikut adalah data username & password anda untuk Login<br/>
        <strong>Email: {{ $user->email }}<br/>
        Password: {{ $password }}</strong><br/>
        Silahkan daftarkan properti referensi anda sekarang lewat <strong>Referral Form</strong> di portal. <a href="{{ route('frontend.account.login') }}" style="font-weight: bold; text-decoration: underline;">Login</a> di website GoProp.co.id<br/>
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
        Portal ini adalah sarana kamu untuk:<br/>
        1. Mengirimkan informasi Owner dari properti yang kamu referensikan<br/>
        2. Memantau status Properti yang kamu referensikan
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
        Prioritas kamu adalah mencari sebanyak-banyaknya info owner atau pemilik langsung properti yang butuh dijual/disewakan. Saat owner bersedia dihubungi oleh pihak GoProp, maka kamu cukup mengisi <strong>Referral Form</strong> lewat Portal.<br/>
        <em>That’s it, tugas kamu selesai!</em>
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
    Tim handal dari GoProp akan melakukan tindak lanjut dan menangani seluruh survey, inspeksi, administrasi, promosi, negosiasi, bahkan hingga transaksi final antara pemilik dengan calon pembeli.<br/>
    <em>Kamu tinggal memantau proses properti yang kamu referensikan di Portal.</em>
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
        Apabila kamu memiliki pertanyaan, silahkan hubungi kami di <a href="tel:{{ config('app.contact_number') }}">{{ config('app.contact_number') }}</a> atau <a href="mailto:marketing@goprop.co.id">marketing@goprop.co.id</a>. Kami akan secepatnya merespon pada jam kerja.</p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">
        Sekali lagi, kami sangat senang dengan kedatangan kamu.<br/>Salam sukses!
    </p>
@stop
