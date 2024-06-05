<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::table('stud_affairs_announcements')->insert([
            [
                'title' => 'CSS Member Onboarding',
                'description' => 'Join us at our Volunteer Onboarding via MS Teams',
                'content' => 'https://www.facebook.com/PLMComputerScienceSociety',
                'image_preview' => 'onboarding.jpg',
                'publish' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CSS DataCampDonates',
                'description' => 'Last Day of Application for DataCampDonates',
                'content' => 'https://www.facebook.com/PLMComputerScienceSociety',
                'image_preview' => 'datacamp.jpg',
                'publish' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
