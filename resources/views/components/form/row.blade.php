@props(['cols' => 1])
@php
    $class = 'mt-3 ';
    if ($cols > 1) {
        $class .= "form-row-$cols";
    }
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>
