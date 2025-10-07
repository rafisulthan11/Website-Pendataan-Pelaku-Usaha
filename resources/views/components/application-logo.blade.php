@props(['src' => asset('images/sincan-logo.png'), 'alt' => config('app.name', 'SINCAN')])

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
