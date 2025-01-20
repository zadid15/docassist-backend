<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'diagnosis' => $this->diagnosis,
            'prescription' => $this->prescription,
            'notes' => $this->notes,
            'doctor' => new UserResource($this->doctor),
            'patient' => new PatientResource($this->patient)
        ];
    }
}
