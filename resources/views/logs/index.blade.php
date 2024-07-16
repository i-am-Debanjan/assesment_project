<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-2">Logs</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($currentPageLogs as $log)
                                    <tr>
                                        <td class="border px-4 py-2 whitespace-pre-line">{{ $log }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $currentPageLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
