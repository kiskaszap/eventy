<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<div class="container mx-auto py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Event Image -->
        <div class="lg:w-1/2">
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full rounded-lg shadow-md">
        </div>
        <!-- Event Details -->
        <div class="lg:w-1/2">
            <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
            <p class="text-gray-700 mt-4">{{ $event->description }}</p>
            <ul class="mt-6 space-y-4 text-gray-700">
                <li><strong>Date:</strong> {{ $event->event_date }}</li>
                <li><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</li>
                <li><strong>Location:</strong> {{ $event->location }}</li>
                <li><strong>Address:</strong> {{ $event->address }}</li>
            </ul>
            <form action="{{ route('register.event', ['id' => $event->id]) }}" method="POST" class="mt-8">
                @csrf
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800">
                    Register to Event
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>



