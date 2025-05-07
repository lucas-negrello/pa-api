<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Appointment::class);

        $user = auth()->user();

        $appointments = Appointment::where('user_id', $user->id)->get();

        $sharedAppointments = Appointment::whereHas('sharedWith', function ($query) use ($user) {
            $query->where('granted_user_id', $user->id)
                ->where('resource_type', Appointment::class);
        })->get();

        return response()->json([
            'appointments' => $appointments,
            'shared_appointments' => $sharedAppointments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        Gate::authorize('create', Appointment::class);

        $appointment = Appointment::create($request->validated());
        return response()->json([
            'message' => 'Appointment created successfully',
            'data' => $appointment,
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        Gate::authorize('view', $appointment);

        return response()->json([
            'message' => 'Appointment retrieved successfully',
            'data' => $appointment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        Gate::authorize('update', $appointment);

        $appointment->update($request->validated());
        return response()->json([
            'message' => 'Appointment updated successfully',
            'data' => $appointment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        Gate::authorize('delete', $appointment);

        $appointment->delete();
        return response()->json([
            'message' => 'Appointment deleted successfully',
            'data' => $appointment,
        ]);
    }
}
