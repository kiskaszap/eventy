<div class="container mx-auto py-8">
    <!-- Event Details -->
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 max-w-4xl mx-auto">
        @if (session('message'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Image Section -->
        <div class=" w-full mb-6">
            <img src="{{ asset('storage/' . ($event->image ?? 'default-image.jpg')) }}" 
                 alt="Event Image" 
                 class=" h-24  object-fit rounded-lg">
        </div>

        <!-- Event Information -->
        <div class="text-gray-900 dark:text-white">
            <h1 class="text-lg font-semibold leading-tight text-gray-900 dark:text-white mb-4">
                {{ $event->title }}
            </h1>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2">
                    <p class="font-medium text-gray-500 dark:text-gray-400">
                        <strong>Date:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $event->event_date }}</span>
                    </p>
                </li>
                <li class="flex items-center gap-2">
                    <p class="font-medium text-gray-500 dark:text-gray-400">
                        <strong>Time:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $event->start_time }} - {{ $event->end_time }}</span>
                    </p>
                </li>
                <li class="flex items-center gap-2">
                    <p class="font-medium text-gray-500 dark:text-gray-400">
                        <strong>Location:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $event->location }}</span>
                    </p>
                </li>
                <li class="flex items-center gap-2">
                    <p class="font-medium text-gray-500 dark:text-gray-400">
                        <strong>Address:</strong> <span class="text-gray-900 dark:text-gray-300">{{ $event->address }}</span>
                    </p>
                </li>
            </ul>
            <p class="mt-4 text-sm text-gray-900 dark:text-gray-300">
                {{ $event->description }}
            </p>
            <div class="mt-6  gap-4">
                <!-- Register Button -->
                <form action="{{ route('event.book') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <button type="submit" 
                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <section class="bg-gray-800 py-6 mt-6 rounded-lg max-w-4xl mx-auto">
        <div class="px-4">
            <h2 class="text-lg lg:text-2xl font-bold text-white mb-6">Comments</h2>

            <!-- Notification for login -->
            @guest
                <div class="text-sm text-red-500 mb-4">
                    You must be logged in to post a comment.
                </div>
            @endguest

            <!-- Write Comment -->
            @auth
                <form method="POST" action="{{ route('comments.store', $event->id) }}" class="mb-6">
                    @csrf
                    <textarea 
                        name="content" 
                        rows="4" 
                        placeholder="Write a comment..."
                        class="w-full bg-gray-100 text-gray-900 rounded-lg border border-gray-300 p-2"
                    ></textarea>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mt-2">
                        Post Comment
                    </button>
                </form>
            @endauth

            <!-- Display Comments -->
            @forelse ($comments as $comment)
                <x-comment :comment="$comment" />
            @empty
                <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </section>
</div>
