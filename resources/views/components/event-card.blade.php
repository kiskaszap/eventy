<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <div class="h-56 w-full">
        <a href="#">
            <img class="mx-auto h-full dark:hidden" src="{{ $image ?? 'https://via.placeholder.com/150' }}" alt="{{ $title }}" />
            <img class="mx-auto hidden h-full dark:block" src="{{ $image ?? 'https://via.placeholder.com/150' }}" alt="{{ $title }}" />
        </a>
    </div>
    <div class="pt-6">
        <a href="#" class="text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
            {{ $title ?? 'No Title' }}
        </a>
        <ul class="mt-2 flex flex-col gap-2">
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date: {{ $date ?? 'N/A' }}</p>
            </li>
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    From: {{ $startTime ?? 'N/A' }} - Till: {{ $endTime ?? 'N/A' }}
                </p>
            </li>
            <li class="flex items-center gap-2">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Location: {{ $location ?? 'N/A' }}</p>
            </li>
        </ul>
        <div class="mt-4 flex items-center justify-between gap-4">
            <form action="{{ route('admin.dashboard') }}" method="GET">
                <input type="hidden" name="active_component" value="single-event-display">
                <input type="hidden" name="event_id" value="{{ $id }}">
                <button type="submit" class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4">
                    View Event
                </button>
            </form>
        </div>
    </div>
</div>
