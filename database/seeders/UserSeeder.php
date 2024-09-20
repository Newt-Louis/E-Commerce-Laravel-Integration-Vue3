<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
          [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'phone' => '0123456789',
            'role' => '1',
          ],
          [
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'phone' => '0123456789',
            'role' => '2',
          ],
          [
            'name' => 'admin3',
            'email' => 'admin3@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'phone' => '0123456789',
            'role' => '3',
          ],
          [
            'name' => 'client',
            'email' => 'client@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'phone' => '0123456789',
            'role' => '4',
          ]
    ]);
    }
}
