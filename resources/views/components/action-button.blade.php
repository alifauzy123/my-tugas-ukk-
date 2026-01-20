@props(['size' => 'md', 'variant' => 'primary', 'icon' => null, 'href' => null])

@php
$sizeClasses = [
    'sm' => 'px-2 py-1 text-xs',
    'md' => 'px-3 py-1.5 text-sm',
    'lg' => 'px-4 py-2 text-base',
];

$variantClasses = [
    'primary' => 'bg-blue-100 text-blue-700 hover:bg-blue-200',
    'success' => 'bg-green-100 text-green-700 hover:bg-green-200',
    'danger' => 'bg-red-100 text-red-700 hover:bg-red-200',
    'warning' => 'bg-amber-100 text-amber-700 hover:bg-amber-200',
    'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
];

$size = $sizeClasses[$size] ?? $sizeClasses['md'];
$variant = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

@if($href)
    <a href="{{ $href }}" class="inline-flex items-center gap-2 {{ $size }} {{ $variant }} rounded-lg transition-colors duration-200 font-medium">
        @if($icon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes }} class="inline-flex items-center gap-2 {{ $size }} {{ $variant }} rounded-lg transition-colors duration-200 font-medium cursor-pointer">
        @if($icon)
            <i class="fas {{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
