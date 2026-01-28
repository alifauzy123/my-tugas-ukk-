@props(['title', 'value', 'icon' => 'fa-chart-bar', 'color' => 'blue', 'trend' => null])

@php
$colorClasses = [
    'blue' => 'from-blue-500 to-blue-600',
    'red' => 'from-red-500 to-red-600',
    'green' => 'from-green-500 to-green-600',
    'purple' => 'from-purple-500 to-purple-600',
    'amber' => 'from-amber-500 to-amber-600',
];

$bgGradient = $colorClasses[$color] ?? $colorClasses['blue'];
$iconColorClass = match($color) {
    'blue' => 'bg-blue-400/20 text-blue-200',
    'red' => 'bg-red-400/20 text-red-200',
    'green' => 'bg-green-400/20 text-green-200',
    'purple' => 'bg-purple-400/20 text-purple-200',
    'amber' => 'bg-amber-400/20 text-amber-200',
    default => 'bg-blue-400/20 text-blue-200',
};
@endphp

<div class="group relative bg-gradient-to-br {{ $bgGradient }} rounded-xl shadow-lg p-6 text-white overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105 cursor-pointer">
    <!-- Background Pattern -->
    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-300"></div>
    
    <div class="relative z-10">
        <!-- Header dengan Icon -->
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-white/80">{{ $title }}</p>
                <h3 class="text-3xl font-bold mt-2">{{ $value }}</h3>
                @if($trend)
                    <p class="text-xs {{ $trend > 0 ? 'text-green-200' : 'text-red-200' }} mt-2">
                        <i class="fas {{ $trend > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs($trend) }}% dari minggu lalu
                    </p>
                @endif
            </div>
            <div class="{{ $iconColorClass }} p-3 rounded-lg backdrop-blur-sm">
                <i class="fas {{ $icon }} text-xl"></i>
            </div>
        </div>
    </div>
</div>
