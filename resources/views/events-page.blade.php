<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Page</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <x-navbar />
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-100">All Events</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="h-56 w-full">
                        <a href="{{ route('single-event-page', $event->id) }}">
                            <img class="mx-auto h-full dark:hidden" src="{{ asset('storage/' . ($event->image ?? 'default-image.jpg')) }}" alt="{{ $event->title }}">
                            <img class="mx-auto hidden h-full dark:block" src="{{ asset('storage/' . ($event->image ?? 'default-image.jpg')) }}" alt="{{ $event->title }}">
                        </a>
                    </div>
                    <div class="pt-6">
                        <a href="{{ route('single-event-page', $event->id) }}" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
                            {{ $event->title ?? 'No Title' }}
                        </a>
                        <ul class="mt-2 flex flex-col gap-2">
                            <li class="flex items-center gap-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date: {{ $event->event_date ?? 'N/A' }}</p>
                            </li>
                            <li class="flex items-center gap-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    From: {{ $event->start_time ?? 'N/A' }} - Till: {{ $event->end_time ?? 'N/A' }}
                                </p>
                            </li>
                            <li class="flex items-center gap-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Location: {{ $event->location ?? 'N/A' }}</p>
                            </li>
                        </ul>
                        <div class="mt-4 flex items-center justify-between gap-4">
                            <a href="{{ route('single-event-page', $event->id) }}" class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-600">
                                View Event
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
