<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve activeComponent and eventId from request query
        $activeComponent = $request->input('active_component', 'events'); // Default to "events"
        $eventId = $request->input('event_id', null);
    
        Log::info('Vendor Dashboard:', [
            'activeComponent' => $activeComponent,
            'eventId' => $eventId,
            'authUserId' => auth()->id(),
        ]);
    
        // Initialize variables
        $events = [];
        $event = null;
    
        // Component-specific logic
        if ($activeComponent === 'events') {
            Log::info('Fetching all events');
            $events = Event::all(); // Fetch all events
        } elseif ($activeComponent === 'manage-events') {
            Log::info('Fetching vendor-specific events for manage-events');
            $events = Event::where('created_by', auth()->id())->get(); // Fetch only vendor's events
        } elseif ($activeComponent === 'edit-event' && $eventId) {
            Log::info('Fetching single event for editing', ['event_id' => $eventId]);
            
            // Ensure the event belongs to the vendor
            $event = Event::where('id', $eventId)
                          ->where('created_by', auth()->id()) // Restrict to vendor's events
                          ->first();
    
            if (!$event) {
                Log::warning('Event not found or not authorized', ['event_id' => $eventId, 'user_id' => auth()->id()]);
                return redirect()->route('vendor.dashboard', ['active_component' => 'manage-events'])
                                 ->with('error', 'Event not found or you are not authorized to edit it.');
            }
        } elseif ($activeComponent === 'single-event-display' && $eventId) {
            Log::info('Fetching single event for display', ['event_id' => $eventId]);
            
            // Fetch the event by ID (no restriction on created_by for viewing)
            $event = Event::find($eventId);
    
            if (!$event) {
                Log::warning('Event not found', ['event_id' => $eventId]);
                return redirect()->route('vendor.dashboard', ['active_component' => 'events'])
                                 ->with('error', 'Event not found.');
            }
        }
    
        // Return the view with data
        return view('vendor-dashboard', [
            'activeComponent' => $activeComponent,
            'events' => $events,
            'event' => $event,
        ]);
    }
    
    
    
    public function setActiveComponent(Request $request)
    {
        $activeComponent = $request->input('active_component', 'events');
        $eventId = $request->input('event_id', null);

        // Log the change
        Log::info('setActiveComponent called', ['activeComponent' => $activeComponent, 'eventId' => $eventId]);

        // Redirect with query parameters
        return redirect()->route('vendor.dashboard', [
            'active_component' => $activeComponent,
            'event_id' => $eventId,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'address' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $validated['created_by'] = auth()->id();

        Log::info('Creating new event', ['data' => $validated]);

        Event::create($validated);

        return redirect()->route('vendor.dashboard', ['active_component' => 'manage-events'])
                         ->with('success', 'Event created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'address' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $event = Event::where('created_by', auth()->id())->findOrFail($id);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Log::info('Updating event', ['event_id' => $id, 'data' => $validated]);

        $event->update($validated);

        return redirect()->route('vendor.dashboard', ['active_component' => 'manage-events'])
                         ->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::where('created_by', auth()->id())->findOrFail($id);

        Log::info('Deleting event', ['event_id' => $id]);

        $event->delete();

        return redirect()->route('vendor.dashboard', ['active_component' => 'manage-events'])
                         ->with('success', 'Event deleted successfully!');
    }

    public function bookEvent(Request $request)
    {
        $eventId = $request->input('event_id');
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        Log::info('Booking event', [
            'user_id' => auth()->id(),
            'event_id' => $eventId,
        ]);

        // Add booking logic here (e.g., save to bookings table)
        // Placeholder for demonstration:
        $user = auth()->user();
        Log::info("User {$user->id} has booked event {$eventId}");

        return redirect()->back()->with('success', 'Event booked successfully!');
    }
}
