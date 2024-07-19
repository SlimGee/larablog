<x-app-layout>
    <!--
Install the "flowbite-typography" NPM package to apply styles and format the article content:

URL: https://flowbite.com/docs/components/typography/
-->

    <main class="pt-8 pb-16 min-h-screen antialiased bg-white lg:pt-16 lg:pb-24 dark:bg-gray-900">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
            <article
                class="mx-auto w-full max-w-2xl format format-sm format-blue sm:format-base lg:format-lg dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full"
                                src="https://gravatar.com/avatar/{{ hash('sha256', trim($post->user->email)) }}">
                            <div>
                                <span
                                    class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->user->name }}</span>

                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    <time pubdate datetime="{{ $post->created_at->format('Y-m-d') }}"
                                        title="{{ $post->created_at->format('d M Y') }}">{{ $post->created_at->format('d M Y') }}</time>
                                </p>
                            </div>
                        </div>
                    </address>
                    <h1
                        class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ $post->title }}
                    </h1>

                    <div>
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}">
                                <x-secondary-button>Edit</x-secondary-button>
                            </a>
                        @endcan
                    </div>
                </header>
                <section class="prose-lg md:prose-lg">
                    {!! $post->content !!}
                </section>
            </article>
        </div>
    </main>

</x-app-layout>
