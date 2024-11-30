<div class="bg-white p-4 shadow rounded-lg">
    <img src="{{ $image }}" alt="Event Image" class="w-full h-40 object-cover rounded-t-lg">
    <div class="mt-4">
        <h3 class="text-lg font-semibold">{{ $title }}</h3>
        <p>{{ $date }} | {{ $startTime }} - {{ $endTime }}</p>
        <p>{{ $location }}</p>
        <div class="mt-4 text-right">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <input type="hidden" name="active_component" value="edit-event">
                <input type="hidden" name="event_id" value="{{ $id }}">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit Event
                </button>
            </form>
        </div>
    </div>
</div>
