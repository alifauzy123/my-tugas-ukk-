@props(['rows' => 5])

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200">
                    @for($i = 0; $i < 7; $i++)
                        <th class="px-6 py-4">
                            <div class="h-4 bg-gray-300 rounded animate-pulse"></div>
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @for($i = 0; $i < $rows; $i++)
                    <tr>
                        @for($j = 0; $j < 7; $j++)
                            <td class="px-6 py-4">
                                <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
