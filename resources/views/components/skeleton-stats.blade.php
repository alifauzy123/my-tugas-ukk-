@props(['count' => 4])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @for($i = 0; $i < $count; $i++)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="h-4 bg-gray-300 rounded w-1/2 mb-3 animate-pulse"></div>
                    <div class="h-8 bg-gray-300 rounded w-2/3 animate-pulse"></div>
                </div>
                <div class="h-12 w-12 bg-gray-300 rounded-lg animate-pulse"></div>
            </div>
            <div class="h-3 bg-gray-200 rounded w-1/3 animate-pulse"></div>
        </div>
    @endfor
</div>
