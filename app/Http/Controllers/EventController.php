<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Mail\EventBooked;
use Illuminate\Support\Facades\Mail;

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

        $event = Event::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.dashboard', ['active_component' => 'manage-events'])
                         ->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.dashboard', ['active_component' => 'manage-events'])
                         ->with('success', 'Event deleted successfully!');
    }

    public function bookEvent(Request $request)
    {
        $eventId = $request->input('event_id');
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $user = auth()->user();

        Mail::to($user->email)->send(new EventBooked($event, $user));

        return redirect()->back()->with('success', 'Event booked successfully! A confirmation email has been sent.');
    }
}
