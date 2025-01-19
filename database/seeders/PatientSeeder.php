<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Patient::insert([
            [
                'name' => 'John Doe',
                'email' => '5oF4j@example.com',
                'phone' => '1234567890',
                'address' => '123 Main St',
                'dob' => '1990-01-01',
                'user_id' => 1
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'ZV5jy@example.com',
                'phone' => '9876543210',
                'address' => '456 Elm St',
                'dob' => '1995-05-05',
                'user_id' => 2
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'B0lZD@example.com',
                'phone' => '5555555555',
                'address' => '789 Oak St',
                'dob' => '1985-10-10',
                'user_id' => 1
            ]
        ]);
    }
}
