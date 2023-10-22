<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::create([
            'address'=>json_encode(['ar' => 'الرياض','en' =>'Riyadh']),
            'phones'=>json_encode(['1' => '05544440399','2' =>'0557491690','3'=>'0112062663']),
            // 'phone_1'=>'0544440399',
            // 'phone_2'=>'0544440377',
            'email'=>'twieaq@gmail.com'
           ]);
    }
}
