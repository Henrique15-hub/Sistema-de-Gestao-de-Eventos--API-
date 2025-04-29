<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEvent;
use App\Http\Requests\Event\UpdateEvent;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $events = Event::where('is_public', true)->get();

        return response()->json([
            'message' => 'showing all public events',
            'events' => $events,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvent $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth('sanctum')->id();
        $event = Event::create($validatedData);

        return response()->json([
            'message' => 'Event created with success!',
            'event' => $event,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'message' => 'event not found!',
            ], 404);
        }

        if ($event->user_id !== auth('sanctum')->id()) {
            return response()->json([
                'message' => 'this event is private!',
            ], 403);
        }

        return response()->json([
            'message' => 'showing the requested event',
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvent $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'message' => 'event not found!',
            ], 404);
        }

        if ($event->user_id !== auth('sanctum')->id()) {
            return response()->json([
                'message' => "you cannot update another user's event!",
            ], 403);
        }

        $event->update($validatedData);

        return response()->json([
            'message' => 'event updated with success!',
            'event' => $event->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'message' => 'event not found!',
            ], 404);
        }

        if ($event->user_id !== auth('sanctum')->id()) {
            return response()->json([
                'message' => 'You are not authorized to delete this event.',
            ], 403);
        }

        $event->delete();

        return response()->json([
            'message' => 'event deleted with success!',
        ]);
    }
}
