<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <x-navbar />
    <div class="container mx-auto py-8">
        <!-- Top Component -->
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg flex justify-between items-center mx-auto" style="width: 80%; gap: 1.5rem;">
            <!-- Image Section -->
            <div class="w-1/3 flex justify-center items-center">
                <img src="{{ asset('storage/' . ($event->image ?? 'default-image.jpg')) }}" 
                     alt="Event Image" class="max-h-48 w-full object-cover rounded-md">
            </div>
            <!-- Content Section -->
            <div class="w-2/3 flex flex-col justify-between">
                <h1 class="text-xl font-bold mb-4">{{ $event->title }}</h1>
                <ul class="text-sm space-y-2">
                    <li><strong>Date:</strong> {{ $event->event_date }}</li>
                    <li><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</li>
                    <li><strong>Location:</strong> {{ $event->location }}</li>
                    <li><strong>Address:</strong> {{ $event->address }}</li>
                </ul>
                <p class="mt-4 text-sm">{{ $event->description }}</p>
                <div class="mt-6 text-left">
                    <a href="{{ route('login') }}" 
                       class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 focus:outline-none text-sm">
                       Register
                    </a>
                </div>
            </div>
        </div>

        <!-- Success and Error Messages -->
        @if (session('success'))
        <div style="
            padding: 1rem; 
            margin-top: 1rem; 
            font-size: 0.875rem; 
            color: #22c55e; 
            background-color: #f0fdf4; 
            border: 1px solid #16a34a; 
            border-radius: 0.375rem; 
            width: 80%; 
            margin-left: auto; 
            margin-right: auto;
            text-align: center;
        ">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div style="
            padding: 1rem; 
            margin-top: 1rem; 
            font-size: 0.875rem; 
            color: #dc2626; 
            background-color: #fef2f2; 
            border: 1px solid #b91c1c; 
            border-radius: 0.375rem; 
            width: 80%; 
            margin-left: auto; 
            margin-right: auto;
            text-align: center;
        ">
            {{ session('error') }}
        </div>
        @endif

        <!-- Comment Section -->
        <section class="bg-gray-800 py-6 mt-6 rounded-lg mx-auto" style="width: 80%;">
            <div class="px-4">
                <h2 class="text-lg font-bold text-white mb-4">Comments</h2>

                <!-- Notification for login -->
                @guest
                    <div class="text-sm text-red-500 mb-4">
                        You must be logged in to post a comment.
                    </div>
                @endguest

                <!-- Write Comment -->
                @auth
                    <form class="mb-4">
                        <div class="py-2 px-3 mb-3 bg-gray-200 rounded-lg border border-gray-300">
                            <textarea id="comment" rows="3" placeholder="Write a comment..."
                                class="w-full bg-gray-200 text-gray-900 rounded-lg border border-gray-400 p-2 text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 focus:outline-none text-sm">
                            Post Comment
                        </button>
                    </form>
                @endauth

                <!-- Display Comments -->
                @if ($comments->isEmpty())
                    <p class="text-xs text-gray-400">No comments yet. Be the first to comment!</p>
                @else
                    @foreach ($comments as $comment)
                        <x-comment :comment="$comment" />
                    @endforeach
                @endif
            </div>
        </section>
    </div>
</body>
</html>
