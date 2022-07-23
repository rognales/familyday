@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

We're excited to meet you at **{{config('familyday.eventname')}}!**
We got your details and you may proceed with payment at the link below:-

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>

## Here's your registration summary:-

@component('mail::table', ['participant' => $participant])
| Name       | Staff Id   | Meal Option    | KTMIP Member  
| ------------- |:-------------:|:-------------:|:-------------:|
| {{$participant->name}}      | {{$participant->staff_id}}         |  {{$participant->meal_option}}  | {{$participant->is_member}}
@endcomponent

@if($participant->dependants->count() > 0)
## And your dependants
@component('mail::table')
|Relationship| Name       | Age         
| ------------- |:-------------:|:-------------:|
@foreach ($participant->dependants as $dependant)
| {{$dependant->relationship}} | {{$dependant->name}}      | {{$dependant->age}}         | 
@endforeach
@endcomponent
@endif

@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

See you there!

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
