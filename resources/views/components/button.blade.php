@props(['size' => 'md', 'variant' => 'primary', 'rounded' => true, 'loading' => false, 'disabled' => false])

@php
$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$variantClasses = [
    'primary' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 shadow-md hover:shadow-lg',
    'secondary' => 'bg-gray-100 text-gray-800 hover:bg-gray-200 border border-gray-300',
    'success' => 'bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 shadow-md hover:shadow-lg',
    'danger' => 'bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 shadow-md hover:shadow-lg',
    'warning' => 'bg-gradient-to-r from-amber-500 to-amber-600 text-white hover:from-amber-600 hover:to-amber-700 shadow-md hover:shadow-lg',
    'outline' => 'bg-transparent text-blue-600 border-2 border-blue-600 hover:bg-blue-50',
];

$roundedClass = $rounded ? 'rounded-lg' : 'rounded';
$disabledClass = $disabled ? 'opacity-50 cursor-not-allowed' : '';
$size = $sizeClasses[$size] ?? $sizeClasses['md'];
$variant = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<button {{ $attributes }} 
    class="inline-flex items-center justify-center gap-2 font-medium transition-all duration-200 {{ $size }} {{ $variant }} {{ $roundedClass }} {{ $disabledClass }} disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
    {{ $disabled ? 'disabled' : '' }}>
    @if($loading)
        <i class="fas fa-spinner animate-spin"></i>
    @endif
    {{ $slot }}
</button>
