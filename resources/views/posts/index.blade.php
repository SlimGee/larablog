<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Posts') }}
            </h2>

            <div>
                <a href="{{ route('posts.create') }}">
                    <x-primary-button>Create post</x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Card Blog -->
    <div class="py-10 px-4 mx-auto sm:px-6 lg:py-14 lg:px-8 max-w-[85rem]">
        <!-- Title -->
        <div class="mx-auto mb-10 max-w-2xl text-center lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">The Blog</h2>
        </div>
        <!-- End Title -->

        <!-- Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <a class="flex flex-col p-5 h-full bg-white rounded-xl border border-gray-200 transition-all duration-300 hover:border-transparent hover:shadow-lg group dark:border-neutral-700 dark:hover:border-transparent dark:hover:shadow-black/40"
                    href="{{ route('posts.show', $post) }}">
                    <div class="aspect-w-16 aspect-h-11">
                        <img class="object-cover w-full rounded-xl" src="{{ Storage::url($post->image) }}"
                            alt="Image Description">
                    </div>
                    <div class="my-6">
                        <h3
                            class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                            {{ $post->title }}
                        </h3>
                    </div>
                    <div class="flex gap-x-3 items-center mt-auto">
                        <img class="rounded-full size-8"
                            src="https://gravatar.com/avatar/{{ hash('sha256', trim($post->user->email)) }}"
                            alt="Image Description">
                        <div>
                            <h5 class="text-sm text-gray-800 dark:text-neutral-200">By {{ $post->user->name }}</h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <!-- End Grid -->

        <!-- Card -->
        <div class="mt-12 text-center">
            {{ $posts->links() }}
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Blog -->
</x-app-layout>
