<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <x-navbar />
    <div class="container mx-auto py-8">
        <div class="max-w-2xl mx-auto bg-white text-gray-900 p-6 rounded-lg shadow-lg">
            <img src="{{ asset('storage/' . ($event->image ?? 'default-image.jpg')) }}" 
                 alt="Event Image" class="w-full h-64 object-cover rounded-md mb-4">
            <h1 class="text-2xl font-bold mb-4">{{ $event->title }}</h1>
            <p class="text-sm mb-2"><strong>Date:</strong> {{ $event->event_date }}</p>
            <p class="text-sm mb-2"><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</p>
            <p class="text-sm mb-2"><strong>Location:</strong> {{ $event->location }}</p>
            <p class="text-sm mb-4"><strong>Address:</strong> {{ $event->address }}</p>
            <p class="mb-6">{{ $event->description }}</p>
            <div class="text-right">
                <a href="{{ route('login') }}" 
                   class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-700">
                   Register
                </a>
            </div>

            <!-- Comments Section -->
            <section class="bg-white dark:bg-gray-900 py-8 lg:py-16">
                <div class="max-w-2xl mx-auto px-4">
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white mb-6">Comments</h2>
                    <form method="POST" action="{{ route('comments.store', $event->id) }}" class="mb-6">
                        @csrf
                        <textarea name="comment" rows="4" placeholder="Write a comment..."
                            class="w-full bg-white rounded-lg border border-gray-300 p-2"></textarea>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mt-2">
                            Post Comment
                        </button>
                    </form>

                    @foreach ($comments as $comment)
                        <x-comment :comment="$comment" />
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</body>
</html>
