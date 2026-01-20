@props(['striped' => true, 'hover' => true])

@php
$rowClass = 'px-6 py-4 text-sm text-gray-700';
$classes = 'bg-white ';

if($hover) $classes .= 'hover:bg-blue-50 transition-colors duration-200 ';
if($striped && $attributes->get('striped-row')) $classes .= 'bg-gray-50 ';
@endphp

<tr {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</tr>
