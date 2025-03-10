@component('mail::message')
<div style="direction: rtl; text-align: right; color: #333;">
    <h4 style="color: #333;">{!! $greeting !!}</h4>
    <h4 style="color: #333;">{!! $message !!}</h4>
    <h3 style="direction: rtl; text-align: right; color: #333;">رقم الموعد: {!! $appointment_id !!}</h3>
    <h3 style="direction: rtl; text-align: right; color: #333;">الحيوان: {!! $animal_name !!}</h3>
    @if (!is_null($doctor_name))
        <h3 style="direction: rtl; text-align: right; color: #333;">الدكتور: {!! $doctor_name !!}</h3>
    @endif
    <p style="direction: rtl; text-align: right; color: #333;">شكرا لاستخدامك أليف</p>
</div>
@endcomponent
