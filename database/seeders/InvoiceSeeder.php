<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Invoice::insert([
            [
                'patient_id' => 1,
                'amount' => 1000,
                'status' => 'paid',
            ],
            [
                'patient_id' => 2,
                'amount' => 2000,
                'status' => 'unpaid',
            ]
            ]);
    }
}
