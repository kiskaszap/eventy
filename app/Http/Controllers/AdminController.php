<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Models\Event;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // Default active_component and initialization
        $activeComponent = $request->input('active_component', 'events');
        $eventId = $request->input('event_id');

        // Debug log: Show incoming request data
        Log::info('AdminController@index called', ['request' => $request->all()]);

        // Check activeComponent and event_id
        Log::info('Active component and event ID', [
            'active_component' => $activeComponent,
            'event_id' => $eventId,
        ]);

        // Initialize data
        $users = [];
        $events = [];
        $event = null;

        // Component-specific data fetching
        if ($activeComponent === 'users-list') {
            Log::info('Fetching users from database');
            $users = User::all();
        }

        if ($activeComponent === 'events') {
            Log::info('Fetching events from database');
            $events = Event::all();
        }

        if ($activeComponent === 'manage-events') {
            Log::info('Fetching all events for manage-events component');
            $events = Event::all(); // Fetch all events
            Log::info('Manage events fetched', ['events' => $events]);

            return view('admin-dashboard', [
                'activeComponent' => $activeComponent,
                'events' => $events, // Pass events to the view
            ]);
        }

        if ($activeComponent === 'edit-event') {
            if ($eventId) {
                Log::info('Fetching single event for editing', ['event_id' => $eventId]);
                $event = Event::find($eventId); // Find event by ID
                if ($event) {
                    Log::info('Event fetched for editing', ['event' => $event]);
                    return view('admin-dashboard', [
                        'activeComponent' => $activeComponent,
                        'event' => $event,
                    ]);
                } else {
                    Log::warning('Event not found for editing', ['event_id' => $eventId]);
                }
            }
        }

        if ($activeComponent === 'single-event-display' && $eventId) {
            Log::info('Fetching single event for ID', ['event_id' => $eventId]);
            $event = Event::find($eventId);

            if ($event) {
                Log::info('Fetched single event', ['event' => $event]);
            } else {
                Log::warning('Event not found for ID', ['event_id' => $eventId]);
            }
        }

        // Return the admin-dashboard view
        return view('admin-dashboard', [
            'activeComponent' => $activeComponent,
            'users' => $users,
            'roles' => Role::all(),
            'events' => $events,
            'event' => $event,
        ]);
    }

    /**
     * Update a user's details.
     */
    public function updateUser(Request $request)
    {
        try {
            // Find user by ID
            $user = User::findOrFail($request->id);

            // Validate data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role_id' => 'required|exists:roles,id',
            ]);

            // Update user
            $user->update($validated);

            return response()->json(['message' => 'User updated successfully!']);
        } catch (\Exception $e) {
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update user.'], 500);
        }
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        try {
            // Find user by ID
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully!']);
        } catch (\Exception $e) {
            Log::error('Error deleting user:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }
}
