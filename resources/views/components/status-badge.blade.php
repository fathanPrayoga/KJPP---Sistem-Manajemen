@props(['status'])

@php
    $formattedStatus = strtolower($status ?? '');

    // Default style
    $classes = 'bg-gray-100 text-gray-500';
    $label = ucfirst($status ?? '-');

    if (in_array($formattedStatus, ['selesai', 'completed'])) {
        $classes = 'bg-green-100 text-green-700';
        $label = 'Selesai';
    } elseif (in_array($formattedStatus, ['pending', 'menunggu'])) {
        $classes = 'bg-yellow-100 text-yellow-700';
        $label = 'Pending';
    } elseif (in_array($formattedStatus, ['proses', 'in_progress', 'dalam_proses'])) {
        $classes = 'bg-blue-100 text-blue-800';
        $label = 'Dalam Proses';
    } elseif (in_array($formattedStatus, ['verified', 'terverifikasi'])) {
        $classes = 'bg-green-100 text-green-800'; // Similar to Selesai or distinctive
        $label = 'Verified';
    } elseif (in_array($formattedStatus, ['rejected', 'ditolak'])) {
        $classes = 'bg-red-100 text-red-800';
        $label = 'Rejected';
    }
@endphp

<span {{ $attributes->merge(['class' => 'px-3 py-1 rounded-full text-xs font-bold uppercase ' . $classes]) }}>
    {{ $label }}
</span>