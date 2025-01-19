<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Patient::class);

        $patients = Patient::latest()->get();
        return PatientResource::collection($patients);
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
                'message' => 'Invalid data'
            ], 400);
        } else {
            $data = array_merge($data, ['user_id' => Auth::user()->id]);
            $patient = Patient::create($data);

            return response()->json([
                'message' => 'Patient Data Created Successfully',
                'data' => new PatientResource($patient)
            ]);
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
            return response()->json([
                'message' => 'Patient Data Fetched Successfully',
                'data' => new PatientResource($patient)
            ]);
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
                'message' => 'Invalid data'
            ], 400);
        } else {
            $patient = Patient::find($id);

            if (!$patient) {
                return response()->json([
                    'message' => 'Patient not found, ID: ' . $id
                ], 404);
            } else {
                $patient->update($data);
                return response()->json([
                    'message' => 'Patient Data Updated Successfully',
                    'data' => new PatientResource($patient)
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
    }
}
