<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'phone' => '80500505050',
            'password' => Hash::make('password'),
            'note' => 'Some text for note',
        ]);
    }
}
