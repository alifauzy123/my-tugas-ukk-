@props(['title', 'icon' => 'fa-inbox', 'message' => 'Tidak ada data'])

<div class="flex flex-col items-center justify-center py-12 px-4">
    <div class="text-6xl text-gray-300 mb-4">
        <i class="fas {{ $icon }}"></i>
    </div>
    <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $title }}</h3>
    <p class="text-gray-500 text-sm text-center max-w-md">{{ $message }}</p>
    {{ $slot }}
</div>
