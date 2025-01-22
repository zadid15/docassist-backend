<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Logging;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $this->authorize('viewAny', Invoice::class);
            $invoices = Invoice::latest()->get();
            return InvoiceResource::collection($invoices);
        } catch (Exception $e) {
            Log::error('Failed to get invoices data: ' . $e->getMessage());
            Logging::create([
                'user_id' => Auth::user()->id,
                'message' => 'Failed to get invoices data: ' . $e->getMessage(),
                'action' => request()->fullUrl(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'Failed to get invoices data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Invoice::class);
        $data = $request->validate([
            'patient_id' => 'required',
            'amount' => 'required',
            'status' => 'required|in:paid,unpaid',
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'Failed to create invoice data'
            ], 400);
        } else {
            try {
                $invoice = Invoice::create($data);
                return response()->json([
                    'message' => 'Invoice Data Created Successfully',
                    'data' => new InvoiceResource($invoice)
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Failed to create invoice data: ' . $e->getMessage()
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
        $this->authorize('view', Invoice::class);

        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'message' => 'Details of Invoice not found'
            ], 404);
        } else {
            try{
                return response()->json([
                    'message' => 'Details of Invoice Data Found Successfully',
                    'data' => new InvoiceResource($invoice)
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Failed to get details of invoice data: ' . $e->getMessage()
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
        $this->authorize('update', Invoice::class);

        $data = $request->validate([
            'patient_id' => 'required',
            'amount' => 'required',
            'status' => 'required|in:paid,unpaid',
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'Failed to update details of invoice data'
            ], 400);
        } else {
            try {
                $invoice = Invoice::find($id);
                $invoice->update($data);
                return response()->json([
                    'message' => 'Details of Invoice Data Updated Successfully',
                    'data' => new InvoiceResource($invoice)
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Logging::record(Auth::user()->id, $e->getMessage(),  request()->fullUrl(), request()->ip());
                return response()->json([
                    'message' => 'Failed to update details of invoice data: ' . $e->getMessage()
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
