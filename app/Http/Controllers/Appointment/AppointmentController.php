<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Logging;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $this->authorize('viewAny', Appointment::class);
            $appointments = Appointment::latest()->get();
            return AppointmentResource::collection($appointments);
        } catch (Exception $e) {
            Log::error('Failed to get appointments data: ' . $e->getMessage());
            Logging::create([
                'user_id' => Auth::user()->id,
                'message' => 'Failed to get appointments data: ' . $e->getMessage(),
                'action' => request()->fullUrl(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'Failed to get appointments data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Appointment::class);

        $data = $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required',
            'status' => 'in:pending,confirmed,cancelled',
        ]);

        try {
            $appointment = Appointment::create($data);
            return new AppointmentResource($appointment);
        } catch (Exception $e) {
            Log::error('Failed to create appointment data: ' . $e->getMessage());
            Logging::create([
                'user_id' => Auth::user()->id,
                'message' => 'Failed to create appointment data: ' . $e->getMessage(),
                'action' => request()->fullUrl(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'Failed to create appointment data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $this->authorize('viewAny', Appointment::class);

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Details of Appointment not found, ID: ' . $id
            ], 404);
        } else {
            try {
                return response()->json([
                    'message' => 'Details of Appointment Data Found Successfully',
                    'data' => new AppointmentResource($appointment)
                ]);
            } catch (Exception $e) {
                Log::error('Failed to get details of appointment data: ' . $e->getMessage());
                Logging::create([
                    'user_id' => Auth::user()->id,
                    'message' => 'Failed to get details of appointment data: ' . $e->getMessage(),
                    'action' => request()->fullUrl(),
                    'ip_address' => request()->ip(),
                ]);
                return response()->json([
                    'message' => 'Failed to  get details of appointment data: ' . $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->authorize('update', Appointment::class);

        $data = $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required',
            'status' => 'in:pending,confirmed,cancelled',
        ]);

        try {
            $appointment = Appointment::find($id);
            $appointment->update($data);
            return new AppointmentResource($appointment);
        } catch (Exception $e) {
            Log::error('Failed to update appointment data: ' . $e->getMessage());
            Logging::create([
                'user_id' => Auth::user()->id,
                'message' => 'Failed to update appointment data: ' . $e->getMessage(),
                'action' => request()->fullUrl(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'Failed to update appointment data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->authorize('delete', Appointment::class);

        try {
            $appointment = Appointment::find($id);
            $appointment->delete();
            return response()->json([
                'message' => 'Appointment Data Deleted Successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete appointment data: ' . $e->getMessage());
            Logging::create([
                'user_id' => Auth::user()->id,
                'message' => 'Failed to delete appointment data: ' . $e->getMessage(),
                'action' => request()->fullUrl(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'Failed to delete appointment data: ' . $e->getMessage()
            ]);
        }
    }
}
