<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="h-56 w-full">
        <a href="#">
            <img class="mx-auto h-full object-cover rounded-lg dark:hidden" src="{{ $image ?? 'https://via.placeholder.com/150' }}" alt="{{ $title }}" />
            <img class="mx-auto h-full object-cover rounded-lg hidden dark:block" src="{{ $image ?? 'https://via.placeholder.com/150' }}" alt="{{ $title }}" />
        </a>
    </div>
    <div class="pt-6">
        <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
            {{ $title ?? 'No Title' }}
        </a>
        <ul class="mt-2 flex flex-col gap-2">
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date: <span class="text-gray-700 dark:text-gray-300">{{ $date ?? 'N/A' }}</span></p>
            </li>
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Time: <span class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($startTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($endTime)->format('H:i') }}</span>
                </p>
            </li>
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">City: <span class="text-gray-700 dark:text-gray-300">{{ $location ?? 'N/A' }}</span></p>
            </li>
        </ul>
        <div class="mt-4 flex items-center justify-between gap-4">
            <!-- Edit Event Button -->
            <form method="GET" action="{{ route($route) }}">
                <input type="hidden" name="active_component" value="edit-event">
                <input type="hidden" name="event_id" value="{{ $id }}">
                <button type="submit" class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4">
                    Edit Event
                </button>
            </form>
            <!-- Delete Event Button -->
            <form method="POST" action="{{ route('event.delete', $id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4">
                    Delete Event
                </button>
            </form>
        </div>
    </div>
</div>
