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
