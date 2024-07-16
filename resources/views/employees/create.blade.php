<x-app-layout>
    @section('title','Create employee')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create employee') }}
        </h2>
        @if (session('success') || session('error'))
            <x-alert-message :type="session('success') ? 'success' : 'error'" />
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf

                        <!-- First Name -->
                        <div class="mt-4">
                            <x-input-label for="first_name" :value="__('First name')" />

                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                :value="old('first_name')"  autofocus autocomplete="off" />

                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <!-- Last Name -->
                        <div class="mt-4">
                            <x-input-label for="last_name" :value="__('Last name')" />

                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                :value="old('last_name')"  autofocus autocomplete="off" />

                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <!-- Company -->
                        <div class="mt-4">
                            <x-input-label for="company_id" :value="__('Company')" />

                            <select name="company_id" id="company_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Choose Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                        </div>
                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />

                            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                :value="old('email')"  autocomplete="off" />
                                
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone')" />

                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                :value="old('phone')"  autocomplete="off" />
                                
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
