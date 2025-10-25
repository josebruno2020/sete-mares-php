@props([
    'text' => 'Button',
    'href' => '#',
    'target' => '_self',
    'class' => ''
])

@php
  $defaultClasses = 'default-button uppercase text-white px-4 py-3 md:px-6 md:py-4 rounded transition text-center text-sm md:text-base whitespace-nowrap';
  $classes = $class ? $defaultClasses . ' ' . $class : $defaultClasses;
@endphp

<a href="{{ $href }}" 
   class="{{ $classes }}" 
   target="{{ $target }}"
   {{ $attributes }}>
    {{ $text }}
</a>