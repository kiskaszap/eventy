<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Mail\EventBooked;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use App\Mail\EventDeleted;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'address' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $validated['created_by'] = Auth::id();

        Event::create($validated);

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('components.single-event-display', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('components.edit-event', compact('event'));
    }
    public function editEvent(Request $request)
{
    $eventId = $request->input('event_id');
    $event = Event::findOrFail($eventId);

    return view('admin-dashboard', [
        'activeComponent' => 'edit-event',
        'event' => $event,
    ]);
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'event_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'address' => 'nullable|string|max:255',
        'location' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Check if the event exists and ensure appropriate access
    $eventQuery = Event::where('id', $id);

    if (auth()->user()->role === 'vendor') {
        $eventQuery->where('created_by', auth()->id()); // Vendors can only edit their own events
    }

    $event = $eventQuery->firstOrFail(); // Fetch the event or fail if not authorized

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($event->image) {
            Storage::disk('public')->delete($event->image); // Delete old image
        }
        $validated['image'] = $request->file('image')->store('images', 'public');
    }

    // Update the event
    $event->update($validated);

    // Determine where to redirect
    $redirectTo = $request->input('redirect_to');

    if (!$redirectTo) {
        // Fallback logic: Redirect based on role
        $redirectTo = auth()->user()->role === 'vendor'
            ? route('vendor.dashboard', ['active_component' => 'manage-events'])
            : route('admin.dashboard', ['active_component' => 'manage-events']);
    }

    return redirect($redirectTo)->with('success', 'Event updated successfully!');
}



public function destroy($id)
{
    $event = Event::findOrFail($id);

    // Retrieve the creator's user ID from 'created_by'
    $creatorId = $event->created_by;

    // Find the creator using the ID
    $creator = User::findOrFail($creatorId);

    // Delete the event's image if it exists
    if ($event->image) {
        Storage::disk('public')->delete($event->image);
    }

    // Delete the event
    $event->delete();

    // Send email to the creator
    Mail::to($creator->email)->send(new EventDeleted($event, $creator));

    return redirect()->route('admin.dashboard', ['active_component' => 'manage-events'])
                     ->with('success', 'Event deleted successfully and notification sent to the event creator.');
}
    public function bookEvent(Request $request)
    {
        Log::info('Entering bookEvent method.');
    
        $eventId = $request->input('event_id');
        Log::info('Event ID from request:', ['event_id' => $eventId]);
    
        $event = Event::find($eventId);
    
        if (!$event) {
            Log::warning('Event not found.', ['event_id' => $eventId]);
            return redirect()->back()->with('error', 'Event not found.');
        }
    
        $user = auth()->user();
        Log::info('Authenticated user:', ['user_id' => $user->id]);
    
        // Ellenőrizzük, hogy már létezik-e a foglalás
        $existingBooking = $user->bookedEvents()->where('event_id', $eventId)->exists();
        if ($existingBooking) {
            Log::info('Event already booked by user.', ['user_id' => $user->id, 'event_id' => $eventId]);
            return redirect()->back()->with('error', 'You have already booked this event.');
        }
    
        // Új foglalás létrehozása
        $user->bookedEvents()->attach($eventId);
        Log::info('Event successfully booked.', ['user_id' => $user->id, 'event_id' => $eventId]);
    
        // E-mail küldés a felhasználónak
        try {
            Mail::to($user->email)->send(new EventBooked($event, $user));
            Log::info('Confirmation email sent to user.', ['user_email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation email.', [
                'user_email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }
    
        return redirect()->back()->with('success', 'Event booked successfully! A confirmation email has been sent.');
    }
    public function showSingleEvent($id)
    {
        $event = Event::findOrFail($id); // Fetch the event or fail if not found
        $comments = $event->comments()->with('user')->latest()->get(); // Eager load user relationship
    
        return view('single-event-display', [
            'event' => $event,
            'comments' => $comments,
        ]);
    }
    

    public function cancelBooking(Request $request)
    {
        // Get the event ID from the request
        $eventId = $request->input('event_id');
    
        // Get the currently authenticated user
        $user = auth()->user();
    
        // Find the booking for this event and user
        $booking = \App\Models\Booking::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->first();
    
        // Check if booking exists
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }
    
        // Delete the booking
        $booking->delete();
    
        return redirect()->route('user.dashboard', ['active_component' => 'booked-events'])
            ->with('success', 'Booking canceled successfully.');
    }
    

}
