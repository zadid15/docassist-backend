<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MedicalRecord::insert([
            [
                'patient_id' => 1,
                'doctor_id' => 3,
                'diagnosis' => 'Malaria',
                'prescription' => 'Antimalarial medication',
                'notes' => 'Patient is advised to take the medication daily',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 3,
                'diagnosis' => 'Flu',
                'prescription' => 'Antiviral medication',
                'notes' => 'Patient is advised to take the medication twice daily',
            ]
        ]);
    }
}
