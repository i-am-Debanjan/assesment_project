<x-app-layout>
    @section('title','Employees')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
            <a href="{{ route('employees.create') }}">
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
                        <table class="w-full bg-white text-center">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/4 py-2">Name</th>
                                    <th class="w-1/4 py-2">Email</th>
                                    <th class="w-1/4 py-2">Phone</th>
                                    <th class="w-1/4 py-2">Company name</th>
                                    <th class="w-1/4 py-2">Action</th>

                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @if ($employees->isEmpty())
                                    <tr>
                                        <td colspan="5" class="border px-4 py-2">No employees data available</td>
                                    </tr>
                                @else
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                {{ $employee->first_name . ' ' . $employee->last_name }}</td>
                                            <td class="border px-4 py-2">{{ $employee->email?$employee->email:"N/A" }}</td>
                                            <td class="border px-4 py-2">{{ $employee->phone?$employee->phone:"N/A" }}</td>
                                            <td class="border px-4 py-2">
                                                {{isset($employee->company->name)?$employee->company->name:"N/A"}}
                                            </td>
                                            <td class="border px-4 py-2 ">
                                                <a href="{{ route('employees.edit', $employee->id) }}" class="">
                                                    <x-primary-button class="ms-3">
                                                        {{ __('Edit') }}
                                                    </x-primary-button>
                                                </a>
                                                <a href="{{ route('employees.destroy', $employee->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this employee?')">
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
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
