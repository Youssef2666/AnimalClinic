@component('mail::message')
<div style="direction: rtl; text-align: right;">
    <h4>{!! $greeting !!}</h4>
    <h4>{!! $message !!}</h4>
    <h3 style="direction: rtl; text-align: right;">رمز التفعيل: {!! $code !!}</h3>
    <p style="direction: rtl; text-align: right;">شكرا لاستخدامك أليف</p>
</div>
@endcomponent
