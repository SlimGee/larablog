<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create post
            </h2>
        </div>
    </x-slot>

    <div class="py-16 mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
        <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
            <div class="max-w-xl">

                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Write a new post') }}
                    </h2>


                </header>



                <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Cover image')" />

                        <label class="block mt-2">
                            <span class="sr-only">Choose cover photo</span>
                            <input type="file" name="image"
                                class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white file:disabled:opacity-50 file:disabled:pointer-events-none dark:text-neutral-500 dark:file:bg-blue-500 dark:hover:file:bg-blue-400 hover:file:bg-blue-700">
                        </label>
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-form.select name="status" class="mt-1 w-full">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </x-form.select>

                    </div>


                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-form.input id="title" name="title" type="text" class="block mt-1 w-full"
                            :value="old('title')" required autofocus />

                    </div>


                    <div>
                        <x-input-label for="name" :value="__('Content')" />
                        <x-form.textarea name="content" class="w-full"
                            rows="10">{{ old('content') }}</x-form.textarea>
                    </div>

                    <div class="flex gap-4 items-center">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
