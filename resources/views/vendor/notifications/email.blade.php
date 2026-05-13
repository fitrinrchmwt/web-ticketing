@component('mail::layout')
{{-- ================= HEADER ================= --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding:12px 0;">
            <img
                src="{{ asset('asset/img/logo.png') }}"
                alt="{{ config('app.name') }}"
                style="max-width:160px;height:auto;display:block;"
            >
        </td>
    </tr>
</table>
@endcomponent
@endslot

{{-- ================= BODY ================= --}}
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td style="padding:0 25px;">

{{-- Greeting --}}
<p style="
    font-size:16px;
    font-weight:600;
    margin-bottom:15px;
">
    {{ $greeting ?? 'Halo!' }}
</p>

{{-- Intro --}}
@foreach ($introLines as $line)
<p style="
    font-size:14px;
    line-height:1.6;
    color:#333333;
    margin:0 0 12px 0;
">
    {{ $line }}
</p>
@endforeach

{{-- ================= ACTION BUTTON ================= --}}
@isset($actionText)
<div style="text-align:center; margin:28px 0;">
<a href="{{ $actionUrl }}" target="_blank" style="
    display:inline-block;
    background-color:#8B1E3F;
    color:#ffffff;
    padding:12px 28px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    border-radius:6px;
">
    {{ $actionText }}
</a>
</div>
@endisset

{{-- ================= SUBCOPY (FALLBACK LINK) ================= --}}
@isset($actionText)
<p style="
    font-size:12px;
    color:#777777;
    line-height:1.5;
    margin-top:18px;
">
    Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:
</p>

<p style="
    font-size:12px;
    word-break:break-all;
    color:#555555;
">
    <a href="{{ $actionUrl }}" target="_blank" style="color:#8B1E3F;">
        {{ $actionUrl }}
    </a>
</p>
@endisset

{{-- Outro --}}
@foreach ($outroLines as $line)
<p style="
    font-size:14px;
    line-height:1.6;
    color:#333333;
    margin:12px 0;
">
    {{ $line }}
</p>
@endforeach

{{-- Security Notice --}}
<p style="
    font-size:13px;
    color:#666666;
    margin-top:25px;
">
    Jika Anda <strong>tidak merasa</strong> melakukan permintaan reset password,
    abaikan email ini. Tidak ada perubahan apa pun yang akan dilakukan pada akun Anda.
</p>

{{-- Signature --}}
<p style="
    margin-top:30px;
    font-size:14px;
    color:#333333;
">
    Salam hormat,<br>
    <strong>{{ config('app.name') }} </strong>
</p>

</td>
</tr>
</table>

{{-- ================= FOOTER ================= --}}
@slot('footer')
@component('mail::footer')
<p style="
    font-size:12px;
    color:#999999;
    margin-bottom:0;
">
    © {{ date('Y') }} {{ config('app.name') }}.  
    Seluruh hak cipta dilindungi.
</p>
@endcomponent
@endslot
@endcomponent
