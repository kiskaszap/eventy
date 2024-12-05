<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
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
     * Handle event booking.
     */
    public function bookEvent(Request $request)
{
    try {
        // Felhasználó és esemény lekérése
        $userId = auth()->id();
        $eventId = $request->input('event_id');
        $event = Event::findOrFail($eventId);

        // Ellenőrizd, hogy már regisztrált-e
        $existingBooking = Booking::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You have already registered for this event.');
        }

        // Foglalás mentése
        Booking::create([
            'user_id' => $userId,
            'event_id' => $eventId,
        ]);

        // Küldj értesítő e-mailt a regisztrációról
        $user = auth()->user();
        \Mail::to($user->email)->send(new \App\Mail\EventRegistrationSuccess($event));

        // Vissza a sikeres üzenettel
        return redirect()->back()->with('success', 'You have successfully registered for the event!');
    } catch (\Exception $e) {
        Log::error('Error registering for event:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'An error occurred while registering for the event.');
    }
}

    /**
     * Delete a booking.
     */
    public function deleteApplication($event_id)
    {
        try {
            $userId = auth()->id(); // Get the current logged-in user ID

            // Find the booking for the given event and user
            $booking = Booking::where('event_id', $event_id)
                ->where('user_id', $userId)
                ->first();

            if (!$booking) {
                return redirect()->back()->with('error', 'Booking not found.');
            }

            // Delete the booking
            $booking->delete();

            Log::info('Deleted booking:', [
                'event_id' => $event_id,
                'user_id' => $userId,
            ]);

            return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
                ->with('success', 'Booking canceled successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting booking:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while canceling the booking.');
        }
    }

    /**
     * Cancel a booking from a user.
     */
    public function cancelBooking(Request $request)
    {
        $eventId = $request->input('event_id');
        $user = auth()->user();
        
        // Find the booking record for the event and user
        $booking = Booking::where('user_id', $user->id)
                          ->where('event_id', $eventId)
                          ->first();
        
        if ($booking) {
            // Delete the booking record
            $booking->delete();
            
            return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
                             ->with('success', 'Your booking has been cancelled.');
        }
        
        // If no booking found, return an error
        return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
                         ->with('error', 'Booking not found or already cancelled.');
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
}
