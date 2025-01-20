<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Logging;
use App\Models\Patient;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $this->authorize('viewAny', Patient::class);

            $patients = Patient::latest()->get();
            return PatientResource::collection($patients);
        } catch (Exception $e) {
            Log::error('Failed to get patients data: ' . $e->getMessage());

            Logging::record(Auth::user()->id, 'Failed to get patients data: ' . $e->getMessage(),  request()->fullUrl(), request()->ip());

            return response()->json([
                'message' => 'Failed to get patients data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Patient::class);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|unique:patients',
            'address' => 'required',
            'dob' => 'required',
            'gender' => 'required|in:male,female',
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'Failed to create patient data'
            ], 400);
        } else {
            try {
                $data = array_merge($data, ['user_id' => Auth::user()->id]);
                $patient = Patient::create($data);

                return response()->json([
                    'message' => 'Patient Data Created Successfully',
                    'data' => new PatientResource($patient)
                ]);
            } catch (Exception $e) {
                Log::error('Failed to create patient data: ' . $e->getMessage());

                Logging::record(Auth::user()->id, 'Failed to create patient data: ' . $e->getMessage(),  request()->fullUrl(), request()->ip());

                return response()->json([
                    'message' => 'Failed to create patient data: ' . $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $this->authorize('viewAny', Patient::class);

        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found, ID: ' . $id
            ], 404);
        } else {
            try {
                $patient = Patient::find($id);
                return response()->json([
                    'message' => 'Patient Data Found Successfully',
                    'data' => new PatientResource($patient)
                ]);
            } catch (Exception $e) {
                Log::error('Failed to get details of patient data: ' . $e->getMessage());

                Logging::record(Auth::user()->id, 'Failed to get details of patient data: ' . $e->getMessage(),  request()->fullUrl(), request()->ip());

                return response()->json([
                    'message' => 'Failed to get details of patient data: ' . $e->getMessage()
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
        $this->authorize('update', Patient::class);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'dob' => 'required',
            'gender' => 'required|in:male,female',
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'Failed to update patient data'
            ], 400);
        } else {
            try {
                $patient = Patient::find($id);

                if (!$patient) {
                    return response()->json([
                        'message' => 'Patient not found, ID: ' . $id
                    ], 404);
                }

                $patient->update($data);

                return response()->json([
                    'message' => 'Patient Data Updated Successfully',
                    'data' => new PatientResource($patient)
                ]);
            } catch (Exception $e) {
                Log::error('Failed to update patient data: ' . $e->getMessage());

                Logging::record(Auth::user()->id, 'Failed to update patient data: ' . $e->getMessage(),  request()->fullUrl(), request()->ip());

                return response()->json([
                    'message' => 'Failed to update patient data: ' . $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->authorize('delete', Patient::class);

        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found, ID: ' . $id
            ], 404);
        } else {
            $patient->delete();
            return response()->json([
                'message' => 'Patient Data Deleted Successfully'
            ]);
        }
    }
}
