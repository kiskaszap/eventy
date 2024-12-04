<div class="dark:border-gray-700 dark:bg-gray-800 p-4 shadow rounded-lg">
    <img src="{{ $image }}" alt="Event Image" class="w-full  max-h-72 object-fit rounded-t-lg">
    <div class="mt-4 text-gray-300">
        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
        <h4 class=" font-bold">Date: <span class="  font-normal">{{ $date }}</span> </h4> 
        <h4 class=" font-bold">Time: <span class="  font-normal"> {{  \Carbon\Carbon::parse($startTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($endTime)->format('H:i') }}</span> </h4>
        <h4 class=" font-bold">City:  <span class="  font-normal"> {{ $location }}</span></h4>
        <div class="mt-4 text-right">
        <form method="GET" action="{{ route($route) }}">
    <input type="hidden" name="active_component" value="edit-event">
    <input type="hidden" name="event_id" value="{{ $id }}">
    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
        Edit Event
    </button>
</form>

        </div>
    </div>
</div>
