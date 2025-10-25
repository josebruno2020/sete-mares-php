@props([
    'text' => '',
    'boldWords' => [],
    'marginTop' => false,
    'align' => 'left',
    'fontSize' => 'text-lg',
    'class' => '',
])

@php
    // Classes base
    $baseClasses = 'text-gray-600 leading-relaxed';

    // Adicionar marginTop
    $marginClass = $marginTop ? 'mt-4' : '';

    // Adicionar alinhamento
    $alignClass = '';
    switch ($align) {
        case 'center':
            $alignClass = 'text-center';
            break;
        case 'justify':
            $alignClass = 'text-justify';
            break;
        case 'left':
        default:
            $alignClass = '';
            break;
    }

    // Combinar todas as classes
    $finalClasses = trim($baseClasses . ' ' . $fontSize . ' ' . $marginClass . ' ' . $alignClass . ' ' . $class);

    // Processar o texto para destacar palavras em negrito
    $processedText = '';
    $words = explode(' ', $text);

    foreach ($words as $index => $word) {
        if (in_array($word, $boldWords)) {
            $processedText .= '<span class="font-bold">' . htmlspecialchars($word) . '</span>';
        } else {
            $processedText .= htmlspecialchars($word);
        }

        // Adicionar espaço entre palavras (exceto na última)
        if ($index < count($words) - 1) {
            $processedText .= ' ';
        }
    }
@endphp

<p class="{{ $finalClasses }}" {{ $attributes }}>
    {!! $processedText !!}
</p>
