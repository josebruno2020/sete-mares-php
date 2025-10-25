@props([
    'image' => '',
    'title' => '',
    'class' => ''
])

@php
    $baseClasses = 'valor-card bg-blue-50 w-full max-w-[350px] mx-auto p-8 flex flex-col items-center rounded-lg';
    $finalClasses = trim($baseClasses . ' ' . $class);
@endphp

<article class="{{ $finalClasses }}" {{ $attributes }}>
    <div class="relative w-64 h-64 mb-4">
        <img 
            src="{{ $image }}" 
            alt="{{ $title }}" 
            class="w-full h-full object-cover rounded-full"
            loading="lazy"
        />
    </div>
    
    <h3 class="valor-card-title my-6 uppercase font-bold text-lg text-center" style="font-family: 'Cinzel', serif;">
        {{ $title }}
    </h3>
    
    <div class="valor-card-content">
        {{ $slot }}
    </div>
</article>