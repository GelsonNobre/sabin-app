@props(['span' => 1])

@php
    $class = 'form-col-' . $span;
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>
