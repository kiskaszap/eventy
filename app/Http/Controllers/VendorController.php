<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $activeComponent = $request->input('active_component', 'events'); 
        $authVendorId = auth()->id(); 

        Log::info('Vendor Dashboard Access:', [
            'activeComponent' => $activeComponent,
            'authVendorId' => $authVendorId,
        ]);

        $events = collect(); 
        $event = null; 

        if ($activeComponent === 'events') {
            $events = Event::all(); 
        } elseif ($activeComponent === 'manage-events') {
            Log::info('Fetching vendor-specific events for manage-events.');
            $events = Event::where('created_by', $authVendorId)->get();
        } elseif ($activeComponent === 'single-event-display') {
            $eventId = $request->input('event_id');
            Log::info('Fetching single event for display', ['event_id' => $eventId]);

            $event = Event::where('id', $eventId)
                ->with(['comments'])
                ->first();

            if (!$event) {
                Log::warning('Event not found or not authorized', [
                    'event_id' => $eventId,
                    'authVendorId' => $authVendorId,
                ]);
                return redirect()->route('vendor.dashboard', ['active_component' => 'events'])
                    ->with('error', 'Event not found or you are not authorized to view it.');
            }
        }

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

        Log::info('setActiveComponent called', ['activeComponent' => $activeComponent, 'eventId' => $eventId]);

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

        $user = auth()->user();
        Log::info("User {$user->id} has booked event {$eventId}");

        return redirect()->back()->with('success', 'Event booked successfully!');
    }
}
