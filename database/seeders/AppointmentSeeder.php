<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Appointment::insert([
            [
                'patient_id' => 1,
                'doctor_id' => 2,
                'appointment_date' => '2023-01-01',
                'status' => 'pending',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 2,
                'appointment_date' => '2023-01-02',
                'status' => 'confirmed',
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 2,
                'appointment_date' => '2023-01-03',
                'status' => 'cancelled',
            ]
        ]);
    }
}
