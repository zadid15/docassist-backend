<?php

namespace App\Http\Controllers\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Logging;
use App\Models\MedicalRecord;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MedicalRecordController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', MedicalRecord::class);
        $medicalrecords = MedicalRecord::latest()->get();
        return MedicalRecordResource::collection($medicalrecords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', MedicalRecord::class);
        $data = $request->validate([
            'patient_id' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
            'notes' => 'required',
        ]);
        
        if (!$data) {
            return response()->json([
                'message' => 'Failed to create medical record data'
            ], 400);
        } else {
            try {
                $data = array_merge($data, ['doctor_id' => Auth::user()->id]);
                $medicalrecords = MedicalRecord::create($data);

                return response()->json([
                    'message' => 'Medical Record Data Created Successfully',
                    'data' => new MedicalRecordResource($medicalrecords)
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Failed to create medical record data'
                ], 400);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $this->authorize('viewAny', MedicalRecord::class);

        $medicalrecord = MedicalRecord::find($id);

        if (!$medicalrecord) {
            return response()->json([
                'message' => 'Details of Medical Record not found, ID: ' . $id
            ], 404);
        } else {
            try {
                return response()->json([
                    'message' => 'Details of Medical Record Data Found Successfully',
                    'data' => new MedicalRecordResource($medicalrecord)
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Details of Medical Record Data not found, ID: ' . $id
                ], 400);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->authorize('update', MedicalRecord::class);
        
        $data = $request->validate([
            'patient_id' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
            'notes' => 'required',
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'Failed to update details of medical record data'
            ], 400);
        } else {
            try {
                $data = array_merge($data, ['doctor_id' => Auth::user()->id]);
                $medicalrecord = MedicalRecord::find($id);

                if (!$medicalrecord) {
                    return response()->json([
                        'message' => 'Medical Record not found, ID: ' . $id
                    ], 404);
                } else {
                    $medicalrecord->update($data);
                    return response()->json([
                        'message' => 'Details of Medical Record Data Updated Successfully',
                        'data' => new MedicalRecordResource($medicalrecord)
                    ]);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Failed to update details of medical record data'
                ], 400);
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
