@props(['name', 'alt' => null])

<img src="{{ asset('icons/' . $name . '.svg') }}"
     alt="{{ $alt ?? ucfirst($name) }}"
     {{ $attributes->merge(['class' => 'w-8 h-4']) }}>
