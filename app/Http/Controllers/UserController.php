<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(Request $request)
{
    // Retrieve the active component and event ID
    $activeComponent = $request->input('active_component', 'events');
    $eventId = $request->input('event_id');
    
    Log::info('Active component and event ID:', ['active_component' => $activeComponent, 'event_id' => $eventId]);
    
    $events = [];
    $event = null;


    if ($activeComponent === 'events') {
        // Fetch all events available to users
        $events = Event::all();
        Log::info('Fetched all events for user.', ['events_count' => $events->count()]);
    } elseif ($activeComponent === 'booked-events') {
        // Fetch events booked by the user
        $events = auth()->user()->bookedEvents; // Ensure relationship is used
        Log::info('Fetched booked events for user.', ['user_id' => auth()->id(), 'booked_events_count' => $events->count()]);
    } elseif ($activeComponent === 'single-event-display' && $eventId) {
        // Retrieve the event by ID
        $event = Event::find($eventId);

        if (!$event) {
            Log::warning('Event not found.', ['event_id' => $eventId]);
            return redirect()->route('user.dashboard', ['active_component' => 'events'])
                             ->with('error', 'Event not found.');
        }
        Log::info('Single event fetched successfully.', ['event_id' => $eventId]);
    }

    return view('user-dashboard', [
        'activeComponent' => $activeComponent,
        'events' => $events,
        'event' => $event,
    ]);
}

    

    /**
     * Update a user's details.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully!']);
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }
    public function cancelBooking(Request $request)
{
    $eventId = $request->input('event_id');
    $user = auth()->user();
    
    // Find the booking record for the event and user
    $booking = \App\Models\Booking::where('user_id', $user->id)
                                  ->where('event_id', $eventId)
                                  ->first();
    
    if ($booking) {
        // Delete the booking record
        $booking->delete();
        
        // Optionally, you can send a notification or email about the cancellation
        return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
                         ->with('success', 'Your booking has been cancelled.');
    }
    
    // If no booking found, return an error
    return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
                     ->with('error', 'Booking not found or already cancelled.');
}
}
