<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Upss!')
@else
# @lang('Hola!')
@endif
@endif

{{-- Intro Lines
@foreach ($introLines as $line)
{{ $line }}

@endforeach
--}}

<span>Recibirá este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.</span>

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{-- $actionText --}}
<span>Reestablecer Contraseña</span>
</x-mail::button>
@endisset

{{-- Outro Lines 
@foreach ($outroLines as $line)
{{ $line }}
@endforeach
--}}

<span>Este enlace de reestablecimiento de contraseña expirará en 60 minutos.
<br/>
Si no solicitó un restablecimiento de contraseña, no se requiere ninguna acción adicional.</span>

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Atentamente'),<br>
<span>Servicio de soporte técnico</span>
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Si tienes algún problema haciendo clic en el botón \":actionText\" puedes copiar y pegar el enlace siguiente\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
