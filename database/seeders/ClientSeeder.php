<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'full_name' => 'John Doe',
            'email' => 'john@mail.com',
            'phone' => '0950959595',
            'password' => Hash::make('password'),
            'address' => 'Grand Street 25',
            'birthday' => Carbon::create(2006, 6, 6),
            'note' => 'Some text for note',
        ]);
    }
}
