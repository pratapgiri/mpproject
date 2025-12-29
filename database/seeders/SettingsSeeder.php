<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['id' => 1, 'field_title' => 'Site Title', 'field_name' => 'site_title', 'field_type' => 'text', 'value' => 'M2'],
            ['id' => 2, 'field_title' => 'Site Logo', 'field_name' => 'site_logo', 'field_type' => 'image', 'value' => 'public/uploads/settings/logo.jpg'],
            ['id' => 3, 'field_title' => 'Site Favicon', 'field_name' => 'site_favicon', 'field_type' => 'image', 'value' => 'public/uploads/settings/1602735060.png'],
            ['id' => 4, 'field_title' => 'Website Copyright', 'field_name' => 'website_copyright', 'field_type' => 'text', 'value' => '© 2025 Explore Ease. All rights reserved.'],
            ['id' => 5, 'field_title' => 'Site Email', 'field_name' => 'site_email', 'field_type' => 'email', 'value' => 'no-reply@module.app'],
            ['id' => 6, 'field_title' => 'Auth Token', 'field_name' => 'auth_token', 'field_type' => 'text', 'value' => 'rzlHgHwr7MeKJbl5pfzfOL07JLjspH'],
            ['id' => 7, 'field_title' => 'Welcome Text 1', 'field_name' => 'welcome_text1', 'field_type' => 'text', 'value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen books'],
            ['id' => 8, 'field_title' => 'Welcome Text 2', 'field_name' => 'welcome_text2', 'field_type' => 'text', 'value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen books'],
            ['id' => 9, 'field_title' => 'Welcome Text 3', 'field_name' => 'welcome_text3', 'field_type' => 'text', 'value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen books'],
            ['id' => 10, 'field_title' => 'SMTP Bypass', 'field_name' => 'smtp_bypass', 'field_type' => 'number', 'value' => '1'],
            ['id' => 11, 'field_title' => 'Local User Radius', 'field_name' => 'local_user_radius', 'field_type' => 'number', 'value' => '100'],
        ]);
    }
}
