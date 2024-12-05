<pre>
    {{ print_r($registrations) }}
</pre>


<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="p-6">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
            Users Registered for Your Events
        </h1>
    </div>
    <div class="flex justify-center bg-gray-800">
        <table style="border-collapse: collapse;" class="w-full bg-white rounded-lg shadow dark:border dark:bg-gray-700 dark:border-gray-700">
            <thead>
                <tr class="border-0 text-white">
                    <th class="text-left p-3 px-5">Name</th>
                    <th class="text-left p-3 px-5">Email</th>
                    <th class="text-left p-3 px-5">Event</th>
                    <th class="text-left p-3 px-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $registration)
                    <tr class="dark:border-gray-600 dark:bg-gray-700 bg-gray-800">
                        <td class="p-3 px-5">{{ $registration['name'] }}</td>
                        <td class="p-3 px-5">{{ $registration['email'] }}</td>
                        <td class="p-3 px-5">{{ $registration['registered_event'] }}</td>
                        <td class="p-3 px-5">
                            <form action="{{ route('delete.application', ['event_id' => $registration['event_id'], 'user_id' => $registration['user_id']]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                    Delete Application
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500">No users registered for your events.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
