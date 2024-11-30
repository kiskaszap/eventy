
    <!-- Component content -->

    @if (session('success'))
    <div class="text-green-500">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="text-red-500">
        {{ session('error') }}
    </div>
@endif


    <form action="{{ route('admin.dashboard', ['active_component' => 'events']) }}" method="GET" class="mt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800">
                        Back to Events
                    </button>
                </form>
    <div class="container mx-auto py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-1/2">
                
                    <img class="mx-auto h-full dark:hidden" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" >
                    <img class="mx-auto hidden h-full dark:block" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
            </div>
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                
                <ul class="mt-6 space-y-4 text-gray-700">
                    <li><strong>Date:</strong> {{ $event->event_date }}</li>
                    <li><strong>Time:</strong> {{ $event->start_time }} - {{ $event->end_time }}</li>
                    <li><strong>Location:</strong> {{ $event->location }}</li>
                    <li><strong>Address:</strong> {{ $event->address }}</li>
                </ul>
                <p class="text-gray-700 mt-4">{{ $event->description }}</p>
               
            </div>
            <div class="mt-6">
    <form action="{{ route('event.book', ['event_id' => $event->id]) }}" method="POST">
        @csrf
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800">
            Book Event
        </button>
    </form>
</div>

        </div>
    </div>

