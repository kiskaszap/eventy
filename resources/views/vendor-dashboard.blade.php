<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-900">

    <style>
        /* Sidebar styling */
        #default-sidebar {
            width: 16rem; /* Default sidebar width */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1F2937; /* Gray-800 */
            z-index: 40;
            overflow-y: auto;
            transition: width 0.3s ease-in-out; /* Smooth transition for width */
        }

        /* Main content styling */
        main {
            transition: margin-left 0.3s ease-in-out; /* Smooth transition for margin */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            #default-sidebar {
                width: 0; /* Collapse sidebar */
            }

            main {
                margin-left: 0; /* Remove margin */
                width: 100%; /* Take full width */
            }
        }

        /* Active sidebar */
        #default-sidebar.active {
            width: 16rem; /* Restore sidebar width */
        }

        main.toggled {
            margin-left: 16rem; /* Apply margin for visible sidebar */
        }

        /* Hamburger button */
        #hamburger-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            background-color: #374151; /* Gray-700 */
            color: #FFF;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        #hamburger-btn:hover {
            background-color: #4B5563; /* Gray-600 */
        }
    </style>

    <!-- Hamburger Button -->
    <button 
        id="hamburger-btn" 
        class="md:hidden fixed top-4 left-4 z-50 p-2 text-gray-500 bg-gray-700 rounded-lg focus:outline-none"
    >
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-800">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                @foreach ([ 
                    ['label' => 'Events', 'icon' => 'fa-calendar', 'value' => 'events'],
                    ['label' => 'Create Events', 'icon' => 'fa-plus-circle', 'value' => 'event-create'],
                    ['label' => 'Manage Events', 'icon' => 'fa-edit', 'value' => 'manage-events']
                ] as $option)
                    <li>
                        <form action="{{ route('vendor.dashboard') }}" method="GET">
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
    <main id="main-content" class="ml-64 flex-1 p-4">
        <!-- Main content logic remains unchanged -->
        @if ($activeComponent === 'events')
            <div id="event" class="content">
                <h2 class="text-2xl font-bold mb-4 text-gray-300">Upcoming Events</h2>
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
                            route="vendor.dashboard"
                        />
                    @endforeach
                </div>
            </div>
        @elseif ($activeComponent === 'single-event-display')
            @if ($event)
                <x-single-event-display :event="$event" :comments="$event->comments" route="vendor.dashboard" />
            @else
                <p class="text-red-500">Event not found.</p>
            @endif
        @elseif ($activeComponent === 'event-create')
            <x-event-create />
        @elseif ($activeComponent === 'manage-events')
            <div id="manage-events" class="content">
                <h2 class="text-2xl font-bold mb-4 text-gray-300">Manage Events</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        <x-edit-cards
                            :image="asset('storage/' . ($event->image ?? 'default-image.jpg'))"
                            :title="$event->title"
                            :date="$event->event_date"
                            :startTime="$event->start_time"
                            :endTime="$event->end_time"
                            :location="$event->location"
                            :id="$event->id"
                            :description="$event->description ?? 'No description provided.'"
                            :address="$event->address"
                            route="vendor.dashboard"
                        />
                    @endforeach
                </div>
            </div>
        @elseif ($activeComponent === 'edit-event')
            @if ($event)
                <x-edit-event :event="$event" />
            @else
                <p class="text-red-500">Event not found.</p>
            @endif
        @endif
    </main>

    <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('default-sidebar');
        const mainContent = document.getElementById('main-content');

        // Function to update layout
        function updateLayout() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('hidden');
                mainContent.classList.add('ml-64');
            } else {
                if (!sidebar.classList.contains('active')) {
                    sidebar.classList.add('hidden');
                }
                mainContent.classList.remove('ml-64');
            }
        }

        // Handle sidebar toggle
        hamburgerBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('active');
            if (window.innerWidth >= 768) {
                mainContent.classList.toggle('ml-64');
            }
        });

        // Initialize layout
        window.addEventListener('resize', updateLayout);
        window.addEventListener('load', updateLayout);
    </script>
</body>
</html>
