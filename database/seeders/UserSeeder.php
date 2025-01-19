<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            [
                'name' => 'Muhammad Zadid',
                'email' => 'muhammad.zadid.webdev@gmail.com',
                'password' => Hash::make('061512'),
                'role' => 'admin',
            ],
            [
                'name' => 'Dr. John Doe',
                'email' => 'dr.john.doe@gmailcom',
                'password' => Hash::make('password1'),
                'role' => 'doctor',
            ],
            [
                'name' => 'Nurse. Jane Doe',
                'email' => 'nurse.jane.doe@gmailcom',
                'password' => Hash::make('password2'),
                'role' => 'nurse',
            ]
        ]);
    }
}
