<x-app-layout>
    @section('title','Create company')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create company') }}
            </h2>
        </div>
        @if (session('success') || session('error'))
            <x-alert-message :type="session('success') ? 'success' : 'error'" />
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('companies.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" autofocus autocomplete="off" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                :value="old('email')" autocomplete="off" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- logo -->
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Logo')" />
                            <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo"
                                :value="old('logo')" autocomplete="off" accept=".jpg,.png,.jpeg" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            <!-- Image preview -->
                            <img id="logoPreview" class="mt-4" style="display:none; max-height: 200px;" />
                        </div>

                        <!-- Website -->
                        <div class="mt-4">
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" class="block mt-1 w-full" type="text" name="website"
                                autocomplete="off" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
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

    @section('customJs')
        <script>
            document.getElementById('logo').addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('logoPreview');
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endsection
</x-app-layout>
