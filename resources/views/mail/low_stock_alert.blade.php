@component('mail::message')
<div style="direction: rtl; text-align: right; color: #333;">
    <h4 style="direction: rtl; text-align: right; color: #333;">{!! $greeting !!}</h4>
    
    <p style="direction: rtl; text-align: right; color: #333;">{!! $message !!}</p>
    
    <h3 style="direction: rtl; text-align: right; color: #333;">المخزون الحالي: {!! $stock !!}</h3>

    <p style="direction: rtl; text-align: right; color: #333;">{!! $action !!}</p>

    <p style="direction: rtl; text-align: right; color: #333;">  شكرا لاستخدامك أليف  </p>
</div>
@endcomponent
