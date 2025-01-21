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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
