@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'error' => null, 'helper' => null, 'icon' => null, 'required' => false])

@php
$hasError = $error || $errors->has($name);
@endphp

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="relative">
        @if($icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                <i class="fas {{ $icon }}"></i>
            </span>
        @endif
        
        @if($type === 'textarea')
            <textarea 
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                {{ $attributes }}
                class="w-full {{ $icon ? 'pl-10' : 'px-4' }} py-2.5 border-2 rounded-lg transition-all duration-200 focus:outline-none focus:ring-0 {{ $hasError ? 'border-red-500 focus:border-red-600 bg-red-50' : 'border-gray-300 focus:border-blue-500' }}">{{ $slot }}</textarea>
        @elseif($type === 'select')
            <select 
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes }}
                class="w-full {{ $icon ? 'pl-10' : 'px-4' }} py-2.5 border-2 rounded-lg transition-all duration-200 focus:outline-none focus:ring-0 {{ $hasError ? 'border-red-500 focus:border-red-600 bg-red-50' : 'border-gray-300 focus:border-blue-500' }} appearance-none bg-white cursor-pointer">
                {{ $slot }}
            </select>
            @if(!$icon)
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 pointer-events-none">
                    <i class="fas fa-chevron-down text-xs"></i>
                </span>
            @endif
        @else
            <input 
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                {{ $attributes }}
                class="w-full {{ $icon ? 'pl-10' : 'px-4' }} py-2.5 border-2 rounded-lg transition-all duration-200 focus:outline-none focus:ring-0 {{ $hasError ? 'border-red-500 focus:border-red-600 bg-red-50' : 'border-gray-300 focus:border-blue-500' }}">
        @endif
    </div>
    
    @if($hasError)
        <p class="text-red-500 text-xs font-medium mt-2 flex items-center gap-1">
            <i class="fas fa-exclamation-circle"></i>
            {{ $error || $errors->first($name) }}
        </p>
    @elseif($helper)
        <p class="text-gray-500 text-xs mt-2">{{ $helper }}</p>
    @endif
</div>
