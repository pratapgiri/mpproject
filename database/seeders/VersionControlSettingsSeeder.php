<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VersionControlSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('version_control_settings')->insert([
            ['id' => 1, 'field_title' => 'Android force update', 'field_name' => 'android_force_update', 'field_type' => 'checkbox', 'value' => '1'],
            ['id' => 2, 'field_title' => 'ios force update', 'field_name' => 'ios_force_update', 'field_type' => 'checkbox', 'value' => '0'],
            ['id' => 3, 'field_title' => 'Android version', 'field_name' => 'android_version', 'field_type' => 'text', 'value' => '1.0'],
            ['id' => 4, 'field_title' => 'ios version', 'field_name' => 'ios_version', 'field_type' => 'text', 'value' => '1.0'],
            ['id' => 5, 'field_title' => 'Android maintenance', 'field_name' => 'android_maintenance', 'field_type' => 'checkbox', 'value' => '0'],
            ['id' => 6, 'field_title' => 'Android App Link', 'field_name' => 'android_app_link', 'field_type' => 'text', 'value' => ''],
            ['id' => 7, 'field_title' => 'Android message', 'field_name' => 'android_message', 'field_type' => 'text', 'value' => 'Android Settings'],
            ['id' => 8, 'field_title' => 'ios App Link', 'field_name' => 'ios_app_link', 'field_type' => 'text', 'value' => ''],
            ['id' => 9, 'field_title' => 'ios message', 'field_name' => 'ios_message', 'field_type' => 'text', 'value' => 'ios Setting'],
            ['id' => 10, 'field_title' => 'ios maintenance', 'field_name' => 'ios_maintenance', 'field_type' => 'checkbox', 'value' => '0'],
        ]);
    }
}
