<div class="dark:border-gray-700 dark:bg-gray-800 p-4 shadow rounded-lg">
    <img src="{{ $image }}" alt="Event Image" class="w-full max-h-72 object-cover rounded-t-lg">
    <div class="mt-4 text-gray-300">
        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
        <h4 class="font-bold">Date: <span class="font-normal">{{ $date }}</span></h4>
        <h4 class="font-bold">Time: <span class="font-normal">{{ \Carbon\Carbon::parse($startTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($endTime)->format('H:i') }}</span></h4>
        <h4 class="font-bold">Location: <span class="font-normal">{{ $location }}</span></h4>
       
        <div class="mt-4">
            <h5 class="font-bold">Address:</h5>
            <p>{{ $address }}</p>
        </div>
        <form action="{{ route('event.cancel') }}" method="POST" class="mt-4" onsubmit="return confirmCancellation()">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">
    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
        Cancel Booking
    </button>
</form>

<script>
    function confirmCancellation() {
        return confirm("Are you sure you want to cancel this booking?");
    }
</script>


    </div>
</div>
