<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-900">

    <!-- Sidebar -->
    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-800">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <!-- Sidebar Options -->
                @foreach ([
                    ['label' => 'Browse Events', 'icon' => 'fa-calendar', 'value' => 'events'],
                    ['label' => 'My Booked Events', 'icon' => 'fa-check-circle', 'value' => 'booked-events']
                ] as $option)
                    <li>
                        <form action="{{ route('user.dashboard') }}" method="GET">
                            <input type="hidden" name="active_component" value="{{ $option['value'] }}">
                            <button type="submit" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas {{ $option['icon'] }}"></i>
                                <span class="ms-3">{{ $option['label'] }}</span>
                            </button>
                        </form>
                    </li>
                @endforeach
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center p-2 w-full text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-700 group">
                            <i class="fas fa-sign-out-alt text-red-500"></i>
                            <span class="ms-3 text-red-500">Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-4">
        @if ($activeComponent === 'events')
            <div id="event" class="content">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Available Events</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        <x-event-card 
                            :image="asset('storage/' . ($event->image ?? 'default-image.jpg'))"
                            :title="$event->title"
                            :date="$event->event_date"
                            :startTime="$event->start_time"
                            :endTime="$event->end_time"
                            :location="$event->location"
                            :id="$event->id"
                            route="user.dashboard"
                        />
                    @endforeach
                </div>
            </div>
        @elseif ($activeComponent === 'single-event-display')
            @if ($event)
                <x-single-event-display :event="$event" :comments="$event->comments" route="user.dashboard"/>
            @else
                <p class="text-red-500">Event not found.</p>
            @endif
        @elseif ($activeComponent === 'booked-events')
            <div id="booked-events" class="content">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">My Booked Events</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                    <x-booked-event
    :event="$event"
    :image="asset('storage/' . ($event->image ?? 'default-image.jpg'))"
    :title="$event->title"
    :date="$event->event_date"
    :startTime="$event->start_time"
    :endTime="$event->end_time"
    :location="$event->location"
    :description="$event->description ?? 'No description provided.'"
    :address="$event->address"
/>

                    @endforeach
                </div>
            </div>
        @endif
    </main>

</body>
</html>
