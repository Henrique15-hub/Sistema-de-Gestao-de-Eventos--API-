<?php

namespace App\Http\Controllers\Enrollment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\StoreEnrollment;
use App\Models\Enrollment;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $enrollments = Enrollment::where('user_id', '=', auth()->id())->get();

        return response()->json([
            'message' => 'showing all the enrollments',
            'enrollment' => $enrollments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollment $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth('sanctum')->id();
        $event = Event::find($validatedData['event_id']);

        if (! $event) {
            return response()->json([
                'message' => 'event not found',
            ], 404);
        }

        if ($event->enrollmentCount() >= $event->capacity) {
            return response()->json([
                'message' => 'event is full!',
            ], 400);
        }

        if ($event::where('user_id', '=', auth('sanctum')->id())) {
            return response()->json([
                'message' => 'you are already enrollmented for this event',
            ], 400);
        }

        if (Carbon::now() >= $event->date) {
            return response()->json([
                'message' => 'the event already happened',
            ], 400);
        }

        $enrollment = Enrollment::create($validatedData);

        return response()->json([
            'message' => 'enrollment created with success!',
            'enrollment' => $enrollment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showParticipants(int $event_id): JsonResponse
    {
        $event = Event::find($event_id);

        if (! $event) {
            return response()->json([
                'message' => 'event not found',
            ], 404);
        }

        if ($event->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'only the creator can see the participants!',
            ], 400);
        }

        $participants = Enrollment::with('user');

        return response()->json([
            'message' => 'showing all the participants of the event',
            'participants' => $participants,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $event_id): JsonResponse
    {
        $user_id = auth()->id();
        $enrollment = Enrollment::where('user_id', '=', $user_id)
            ->where('event_id', '=', $event_id)
            ->get();

        if (! $enrollment) {
            return response()->json([
                'message' => 'enrollment not found!',
            ], 404);
        }

        $enrollment->delete();

        return response()->json([
            'message' => 'enrollment deleted.',
        ]);

    }
}
