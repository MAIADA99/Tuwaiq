<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUs::create([
            'name'=>json_encode(['ar' => 'عربي','en' =>'english']),
            'description'=>json_encode(['ar' => 'عربي','en' =>'english']),
            'image'=>''
           ]);
    }
}
