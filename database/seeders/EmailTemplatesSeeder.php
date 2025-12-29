<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $templates = [
            [
                'id' => 1,
                'title' => 'Verification Email',
                'subject' => 'Verify Email OTP',
                'slug' => 'email-verification',
                'content' => '<div><b>Dear User,</b></div><div>Welcome to {{APP_NAME}}</div><div>We appreciate your interest in {{APP_NAME}} and welcome you to our community. To ensure the security of your account, we require you to complete the OTP (One-Time Password) verification process</div><div>OTP : {{OTP}}</div><div>Please use this OTP to verify your account.</div><div>If you have any questions or need assistance, don\'t hesitate to contact our support team at {{APP_EMAIL}}</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Reset Password',
                'subject' => 'Reset Password Verification Code',
                'slug' => 'reset-password',
                'content' => '<div><b>Dear User,</b></div><div>We appreciate your interest in {{APP_NAME}}. To ensure the security of your account, we require you to complete the OTP (One-Time Password) verification process to reset your password.</div><div>OTP : {{OTP}}</div><div>Please use this OTP to verify your account.</div><div>If you have any questions or need assistance, don\'t hesitate to contact our support team at {{APP_EMAIL}}.</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 3,
                'title' => 'Admin Forgot Password',
                'subject' => 'Forgot Password',
                'slug' => 'forgot-password',
                'content' => '<p>Dear Admin,</p><p>We have received a request to reset the password for your admin account on {{APP_NAME}}. If you did not request this change, please ignore this email.</p><p>To reset your password, please click on the following link:</p><p>{{URL}}</p><p>Thank you,</p><p>The {{APP_NAME}} Team</p>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 4,
                'title' => 'Support',
                'subject' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<p>Hello,</p><p>This mail is from {{USER_EMAIL}} ({{USER_NAME}}).</p><p>{{MESSAGE}}</p>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 5,
                'title' => 'OTP Verification',
                'subject' => 'OTP Verification',
                'slug' => 'otp-verification',
                'content' => '<div>Dear User,</div><div>Welcome to {{APP_NAME}}</div><div>We appreciate your interest in {{APP_NAME}} and welcome you to our community. To ensure the security of your account, we require you to complete the OTP (One-Time Password) verification process</div><div>OTP : {{OTP}}</div><div>Please use this OTP to verify your account.</div><div>If you have any questions or need assistance, don\'t hesitate to contact our support team at {{APP_EMAIL}}</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 6,
                'title' => 'Account delete request',
                'subject' => 'Account delete request',
                'slug' => 'account-deletion',
                'content' => '<div>Hello,</div><div>Account delete request from {{USER_EMAIL}} ({{USER_NAME}}).</div><div>{{MESSAGE}}</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 7,
                'title' => 'Account Active',
                'subject' => 'Account Active',
                'slug' => 'account-active',
                'content' => '<div>Hello,</div><div>Account has been activated for {{USER_EMAIL}} ({{USER_NAME}}).</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 8,
                'title' => 'Account Inactive',
                'subject' => 'Account Inactive',
                'slug' => 'account-inactive',
                'content' => '<div>Hello,</div><div>Account has been deactivated for {{USER_EMAIL}} ({{USER_NAME}}).</div>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
            [
                'id' => 9,
                'title' => 'Support',
                'subject' => 'Support Response',
                'slug' => 'support-response',
                'content' => '<p>Hello {{USER_NAME}},</p><p>We appreciate your interest in {{APP_NAME}}.</p><p>{{MESSAGE}}</p>',
                'keywords' => '{link},{url}',
                'status' => 1,
            ],
        ];

        DB::table('email_templates')->insert($templates);
    }
}
