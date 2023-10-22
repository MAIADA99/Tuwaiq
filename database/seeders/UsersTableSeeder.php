<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'maiada',
            'email' => 'maiada@yahoo.com',
            'password' => bcrypt('123456789'),
            'role'=>'admin',
           ]);
    }
}
