@props(['active' => false])

<span {{ $attributes->merge(['class' => 'px-3 py-1 rounded-full text-xs font-bold uppercase ' . ($active ? 'bg-primary-light text-primary-dark' : 'bg-gray-100 text-gray-500')]) }}>
    {{ $slot }}
</span>