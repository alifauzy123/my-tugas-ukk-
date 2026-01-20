@props(['headers' => [], 'items' => []])

<div class="overflow-x-auto rounded-xl shadow-lg">
    <table class="w-full">
        <thead>
            <tr class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                @foreach($headers as $header)
                    <th class="px-6 py-4 text-left text-sm font-semibold {{ $loop->first ? 'rounded-tl-xl' : '' }} {{ $loop->last ? 'rounded-tr-xl' : '' }}">
                        {{ $header }}
                    </th>
                @endforeach
                <th class="px-6 py-4 text-left text-sm font-semibold rounded-tr-xl">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
