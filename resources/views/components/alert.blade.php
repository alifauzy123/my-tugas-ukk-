@props(['type' => 'success', 'message', 'dismissible' => true])

@php
$alertClasses = [
    'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => 'fa-check-circle', 'textColor' => 'text-green-800', 'bgIcon' => 'bg-green-100 text-green-600'],
    'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'fa-exclamation-circle', 'textColor' => 'text-red-800', 'bgIcon' => 'bg-red-100 text-red-600'],
    'warning' => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'icon' => 'fa-exclamation-triangle', 'textColor' => 'text-amber-800', 'bgIcon' => 'bg-amber-100 text-amber-600'],
    'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon' => 'fa-info-circle', 'textColor' => 'text-blue-800', 'bgIcon' => 'bg-blue-100 text-blue-600'],
];

$config = $alertClasses[$type] ?? $alertClasses['info'];
@endphp

<div class="alert-{{ $type }} {{ $config['bg'] }} {{ $config['border'] }} border rounded-lg p-4 flex items-start gap-3 transition-all duration-300 animate-in fade-in slide-in-from-top-2">
    <div class="{{ $config['bgIcon'] }} p-2 rounded-lg flex-shrink-0">
        <i class="fas {{ $config['icon'] }}"></i>
    </div>
    <div class="flex-1">
        <p class="{{ $config['textColor'] }} text-sm font-medium">{{ $message }}</p>
    </div>
    @if($dismissible)
        <button type="button" onclick="this.closest('.alert-{{ $type }}').remove()" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0">
            <i class="fas fa-times"></i>
        </button>
    @endif
</div>
