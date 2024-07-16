<x-app-layout>
    @section('title','Companies')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Companies') }}
            </h2>
            <a href="{{ route('companies.create') }}">
                <x-primary-button class="ms-0">
                    {{ __('Create') }}
                </x-primary-button>
            </a>
        </div>
        @if (session('success') || session('error'))
            <x-alert-message :type="session('success') ? 'success' : 'error'" />
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/4 py-2">Name</th>
                                    <th class="w-1/4 py-2">Email</th>
                                    <th class="w-1/4 py-2">Logo</th>
                                    <th class="w-1/4 py-2">Website</th>
                                    <th class="w-1/4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-center">
                                @if ($companies->isEmpty())
                                    <tr>
                                        <td colspan="5" class="border px-4 py-2">No companies data available</td>
                                    </tr>
                                @else
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $company->name ? $company->name : 'N/A' }}</td>
                                            <td class="border px-4 py-2">{{ $company->email ? $company->email : 'N/A' }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                @if ($company->logo)
                                                    <img src="{{ Storage::url($company->logo) }}" alt="Logo"
                                                        class="w-16 h-16">
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2"><a href="{{ $company->website }}"
                                                    class="text-blue-500"
                                                    target="_blank">{{ $company->website ? $company->website : 'N/A' }}</a>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('companies.edit', $company->id) }}" class="">
                                                    <x-primary-button class="ms-3">
                                                        {{ __('Edit') }}
                                                    </x-primary-button>
                                                </a>
                                                <a href="{{ route('companies.destroy', $company->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this company?')">
                                                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- For Custom js -->
    @section('customJs')
    @endsection
</x-app-layout>
