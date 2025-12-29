<?php

namespace App\Http\Controllers\Api\V1;

use App\Lib\Email;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\BlockUser;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public $otpExpiryTime = '+5 minute';

    public function checkUser(Request $req)
    {
        try {
            // Validate incoming data
            $validator = Validator::make($req->all(), [
                'register_type' => 'required|in:email,mobile',
                'email' => 'nullable|email|required_if:register_type,email',
                'mobile_number' => 'nullable|numeric|min:10|required_if:register_type,mobile',
                'country_code' => 'nullable|min:2|max:4|required_if:register_type,mobile',
                'user_type' => 'nullable|in:user,business',
                'is_resend' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => (object) [],
                ]);
            }

            $otp = generateEmailOTP(); // Generate OTP
            $otp_expiry = now()->addMinutes($this->otpExpiryTime);
            $userOtp = null;

            if ($req->register_type == 'email') {
                // Check if email exists
                if (checkEmailExist($req->email)) {
                    return response()->json([
                        'status' => false,
                        'message' => Config::get('message-constants.Email_exist'),
                        'data' => (object) [],
                    ]);
                }
                $userOtp = UserOtp::where('email', $req->email)->first();
            } else {
                if ($req->register_type == 'mobile') {
                    // Check if mobile number exists
                    if (checkMobileExist($req->mobile_number, $req->country_code)) {
                        return response()->json([
                            'status' => false,
                            'message' => Config::get('message-constants.Mobile_exist'),
                            'data' => (object) [],
                        ]);
                    }
                    // Find existing OTP entry
                    $userOtp = UserOtp::where('mobile_number', $req->mobile_number)
                        ->where('country_code', $req->country_code)
                        ->first();
                }
            }

            // Resend OTP logic
            if ($req->is_resend == 1 && $userOtp) {
                $userOtp->update([
                    'otp' => $otp,
                    'opt_expiry' => $otp_expiry,
                ]);
                $email_data['otp'] = $otp;

                $emailData = Email::send('email-verification', $email_data, $req->email, "Verify Email OTP");

                return response()->json([
                    'status' => true,
                    'message' => Config::get('message-constants.OTP_Resent'),
                    'data' => ['otp' => $otp],
                ]);
            }

            // If OTP doesn't exist, create new one
            if ($req->register_type === 'email') {
                UserOtp::updateOrCreate(
                    ['email' => $req->email],
                    [
                        'otp' => $otp,
                        'opt_expiry' => $otp_expiry
                    ]
                );
                $email_data['otp'] = $otp;
                $emailData =  Email::send('email-verification', $email_data, $req->email, "Verify Email OTP");
            } else {
                UserOtp::updateOrCreate(
                    ['mobile_number' => $req->mobile_number, 'country_code' => $req->country_code,],
                    [
                        'otp' => $otp,
                        'opt_expiry' => $otp_expiry
                    ]
                );
            }

            return response()->json([
                'status' => true,
                'message' => Config::get('message-constants.OTP_Verification'),
                'data' => ['otp' => $otp],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => (object) [],
            ]);
        }
    }

    // This method is used for user signup
    public function signup(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'email' => 'nullable|string|email|unique:users,email',
                'mobile_number' => 'nullable|unique:users,mobile_number',
                'country_code' => 'nullable',
                'password' => 'required',
                'name' => 'nullable',
                'user_type' => 'nullable|in:user,business',
                'device_type' => 'required|in:IPHONE,ANDROID,IOS',
                'device_token' => 'required',
                'device_unique_id' => 'required',
                'otp' => 'required|min:6|max:6',
            ], [
                'email.unique' => 'Email address already exists',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $otp = verifyOtp($data);
            if (!$otp) {
                return response()->json(['status' => false, 'message' => Config::get('message-constants.Valid_OTP'), 'data' => (object) []]);
            }

            // Check OTP expiration
            if (isOtpExpired($otp)) {
                return response()->json(['status' => false, 'message' => Config::get('message-constants.OTP_expired'), 'data' => (object) []]);
            }

            // Delete OTP after verification
            $otp->delete();
            // Register User
            $user = new User();
            $user->email = $data['email'] ?? null;
            $user->name = $data['name'] ?? null;
            $user->mobile_number = $data['mobile_number'] ?? null;
            $user->country_code = $data['country_code'] ?? null;
            $user->user_type = $data['user_type'] ?? null;
            $user->password = Hash::make($data['password']);
            $user->verified_at = Carbon::now();
            $user->otp_verify = 1;
            $user->status = 1;

            if ($request->file('profile_picture')) {
                $destinationPath = '/public/uploads/profile_picture/';
                $imagePath = $request->file('profile_picture');
                $image = uploadImage($imagePath, $destinationPath);
                $user->profile_picture = $image;
            }


            $user->save();

            // Insert Device Data
            UserDevice::deviceHandle([
                "id" => $user->id,
                "device_type" => $data['device_type'],
                "device_token" => $data['device_token'],
                "device_unique_id" => $data['device_unique_id'],
            ]);

            // Generate JWT token
            $jwtToken = JWTAuth::fromUser($user->refresh());
            $message = Config::get('message-constants.Signup_successful');

            return response()->json(['status' => true, 'message' => $message, 'data' => $user, 'token' => $jwtToken]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => (object) []]);
        }
    }



    // This method is used for signin
    public function signin(Request $request)
    {
        try {
            // Retrieve all input data
            $data = $request->all();

            // Get current time for logging
            $date = now()->format('Y-m-d h:i:s');

            // Validate request input
            $validator = Validator::make($data, [
                'email' => 'nullable|email|string',
                'mobile_number' => 'nullable|string',
                'country_code' => 'nullable|string',
                'password' => 'required|string',
                'device_type' => 'required|in:IPHONE,ANDROID,IOS',
                'device_token' => 'required|string',
                'device_unique_id' => 'required|string',
            ]);

            // Return validation error if fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            // Attempt to retrieve the user by email or mobile number
            $user = null;
            if (!empty($data['email'])) {
                $user = User::where('email', $data['email'])->first();
            }

            if (!$user && !empty($data['mobile_number'])) {
                $user = User::where('mobile_number', $data['mobile_number'])
                    ->where('country_code', $data['country_code'] ?? null)
                    ->first();
            }

            // Return error if user does not exist
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.User_not_exist'),
                    'data' => (object) [],
                ]);
            }

            // Account verification and status checks
            if (empty($user->verified_at) && $user->status == 0 && $user->otp_verify == 0) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Account_not_verified'),
                    'data' => (object) [],
                ], 201);
            }

            if ($user->status == 0) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Account_deactivated'),
                    'data' => (object) [],
                ], 201);
            }

            // Check password validity
            if (!Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Wrong_credentials'),
                    'data' => (object) [],
                ]);
            }

            // Generate JWT token
            $jwtToken = JWTAuth::fromUser($user->refresh());
            if (!$jwtToken) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Wrong_credentials'),
                    'data' => (object) [],
                ]);
            }

            // Handle device login
            UserDevice::deviceHandle([
                "id" => $user->id,
                "device_type" => $data['device_type'],
                "device_token" => $data['device_token'],
                "device_unique_id" => $data['device_unique_id'],
            ]);

            // Retrieve device details
            $device = UserDevice::where([
                'user_id' => $user->id,
                'device_type' => $data['device_type'],
                'device_unique_id' => $data['device_unique_id']
            ])->first();

            // Set user preferences from device settings

            // Return success response with JWT token
            return response()->json([
                'status' => true,
                'message' => Config::get('message-constants.Login_success'),
                'data' => $user,
                'token' => $jwtToken,
            ]);
        } catch (\Exception $e) {
            // Catch any exceptions and return error response
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => (object) [],
            ]);
        }
    }

    // Forgot Password with OTP
    public function forgotPasswordOtp(Request $request)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
                'country_code' => 'nullable',
                'mobile_number' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => (object) [],
                ]);
            }

            // Check user by email or mobile number
            $user = null;
            if ($request->email) {

                $user = User::where('email', $request->email)->first();
            } elseif ($request->mobile_number && $request->country_code) {
                $user = User::where('mobile_number', $request->mobile_number)
                    ->where('country_code', $request->country_code)
                    ->first();
            }

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.User_not_exist'),
                    'data' => (object) [],
                ]);
            }

            // Check account status and verification
            if ($user->otp_verify == 0 && $user->status == 0) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Account_not_verified'),
                    'data' => (object) [],
                ]);
            } elseif ($user->status == 0) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Account_deactivated'),
                    'data' => (object) [],
                ]);
            }

            // Generate OTP
            $otp = generateEmailOTP();

            if ($request->email) {
                UserOtp::create([
                    'email' => $user->email,
                    'otp' => $otp,
                    'otp_expiry' => Carbon::now()->addMinutes(15),
                ]);
                $email_data['otp'] = $otp;

                Email::send('reset-password', $email_data, $request->email, "Reset Password Verification Code");
            }

            if ($request->mobile_number) {
                UserOtp::create([
                    'mobile_number' => $user->mobile_number,
                    'country_code' => $user->country_code,
                    'otp' => $otp,
                    'otp_expiry' => Carbon::now()->addMinutes(15),
                ]);
            }
            // Send OTP via email or SMS (depending on your integration)
            // Send OTP via mail/SMS logic here
            return response()->json([
                'status' => true,
                'message' => Config::get('message-constants.Reset_Password_OTP'),
                'data' => (object)[],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => (object) [],
            ]);
        }
    }

    // This method use for forgot password
    public function resetPassword(Request $request)
    {
        try {
            $response = [
                'status' => false,
                'data' => (object) [],
            ];

            // Validate input: at least email or mobile number is required, along with password
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
                'mobile_number' => 'nullable|string',
                'country_code' => 'nullable:mobile_number|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $user = null;

            // Fetch user by email
            if ($request->filled('email')) {
                $user = User::where('email', $request->email)->first();
            }

            // If no user found with email, try mobile number
            if (!$user && $request->filled('mobile_number') && $request->filled('country_code')) {
                $user = User::where('mobile_number', $request->mobile_number)
                    ->where('country_code', $request->country_code)
                    ->first();
            }

            // If user still not found
            if (!$user) {
                $response['message'] = Config::get('message-constants.User_not_exist');
                return response()->json($response);
            }

            // Check if account is deactivated
            if ($user->status == 0) {
                $response['message'] = Config::get('message-constants.Account_deactivated');
                return response()->json($response);
            }

            // $otp = $this->verifyOtp($request->all());
            // if (!$otp) {
            //     return response()->json(['status' => false, 'message' => Config::get('message-constants.Valid_OTP'), 'data' => (object) []]);
            // }

            // Check OTP expiration
            // if ($this->isOtpExpired($otp)) {
            //     return response()->json(['status' => false, 'message' => Config::get('message-constants.OTP_expired'), 'data' => (object) []]);
            // }

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();
            // $otp->delete();

            $response['status'] = true;
            $response['message'] = Config::get('message-constants.Password_Reset');
            $response['data'] = $user->refresh();

            return response()->json([
                'status' => true,
                'message' => Config::get('message-constants.Password_Reset'),
                'data' => $user->refresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => (object) [],
            ]);
        }
    }


    // This method is use to resend
    public function sendOtp(Request $request)
    {
        try {
            // Validate the input data
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'country_code' => 'nullable|string',
                'mobile_number' => 'nullable|string',
                'is_resend' => 'required|in:0,1',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            // Determine the appropriate message based on the is_resend flag
            $message = $request->is_resend
                ? Config::get('message-constants.OTP_Verification_resent')
                : Config::get('message-constants.OTP_Verification');

            // Check if the email exists in the system
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => Config::get('message-constants.Email_not_exist'),
                    'data' => (object) []
                ]);
            }

            // Generate OTP and expiry time
            $otp = generateEmailOTP();
            $otp_expiry_time = Carbon::now()->addMinutes(15);

            // Determine the user OTP record based on email or mobile number
            $userOtp = null;
            if ($request->email) {
                $userOtp = UserOtp::where('email', $request->email)->first();
            } elseif ($request->mobile_number && $request->country_code) {
                $userOtp = UserOtp::where('mobile_number', $request->mobile_number)
                    ->where('country_code', $request->country_code)
                    ->first();
            }

            // If OTP record exists, update it, otherwise create a new one
            if ($userOtp) {
                // Update OTP if it exists
                $userOtp->update([
                    'otp' => $otp,
                    'otp_expiry' => $otp_expiry_time,
                ]);
            } else {
                // Create new OTP record if it doesn't exist
                UserOtp::create([
                    'email' => $request->email ?: null,
                    'mobile_number' => $request->mobile_number ?: null,
                    'country_code' => $request->country_code ?: null,
                    'otp' => $otp,
                    'otp_expiry' => $otp_expiry_time,
                ]);
            }

            // Prepare OTP data for sending via email
            $email_data = ['otp' => $otp];

            // Send OTP email (this line is commented for now)
            // Email::send('otp-verification', $email_data, $request->email, "Verify Email OTP");

            // Return success response with OTP data
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => [
                    'email' => $request->email,
                    'otp' => $otp
                ]
            ]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => (object) []
            ]);
        }
    }


    // user logout
    public function userLogout(Request $request)
    {
        try {

            $data = $request->all();
            $response['status'] = false;
            $response['message'] = '';
            $response['data'] = (object) [];

            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            if (!$userId) {
                throw new \Exception("Error Processing Request", 1);
            }

            $validator = Validator::make($request->all(), [
                'device_type' => 'required|in:IPHONE,ANDROID,IOS',
                'device_token' => 'required',
            ]);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
            } else {
                $userLogged = JWTAuth::toUser(JWTAuth::getToken());
                $userDevice = UserDevice::where(['user_id' => $userLogged->id, 'device_type' => $data['device_type'], 'device_token' => $data['device_token']])->first();
                if ($userDevice) {
                    JWTAuth::invalidate(JWTAuth::getToken());

                    $userDevice->device_type = NULL;
                    $userDevice->device_token = NULL;
                    $userDevice->save();
                    $response['status'] = true;
                    $response['message'] = Config::get('message-constants.Logout_success');
                } else {
                    $response['message'] = Config::get('message-constants.Logout_error');
                }
            }
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => (object) []]);
        }
    }

    // Create and edit profile
    public function createEditProfile(Request $request)
    {
        try {
            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            $validator = Validator::make($request->all(), [
                'name' => 'nullable',
                'mobile_number' => 'nullable',
                'country_code' => 'nullable',
                'profile_picture' => 'nullable',
                'address' => 'nullable',
                'gender'=>'nullable',
                'targets'=>'nullable',
                'key' => 'required|in:1,0'
            ]);
            // Handle validation failure
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => (object) []
                ]);
            }
            // Retrieve the user from the database
            $user = User::find($userId);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                    'data' => (object) []
                ]);
            }
            $data = $request->all();
            if ($request->file('profile_picture')) {
                $destinationPath = '/public/uploads/profile_picture/';
                $imagePath = $request->file('profile_picture');
                $image = uploadImage($imagePath, $destinationPath);
                $data['profile_picture'] = $image;
            }
            $updateStatus = $user->update($data);
            $message = $request->key ? Config::get('message-constants.Profile_updated') : Config::get('message-constants.Profile_created');

            return response()->json([
                'status' => $updateStatus,
                'message' => $updateStatus ? $message : Config::get('message-constants.Something_wrong'),
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }





    public function changePassword(Request $request)
    {
        try {
            $response['status'] = false;
            $response['data'] = (object) [];
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required',
            ]);
            if ($validator->fails()) {

                $response['status'] = false;
                $response['message'] = $validator->errors()->first();
                $response['data'] = (object) [];
                return response()->json($response);
            } else {
                $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

                $user = User::find($userId);
                if (!$user) {
                    return response()->json(['status' => false, 'message' => Config::get('message-constants.User_not_exist'), 'data' => (object) []]);
                } else {
                    if ($data['current_password'] == $data['new_password']) {
                        $response['status'] = false;
                        $response['message'] = Config::get('message-constants.Password_not_same');
                        $response['data'] = (object) [];
                        return response()->json($response);
                    } else if (Hash::check($data['current_password'], $user->password)) {
                        $user->password = Hash::make($data['new_password']);
                        $user->save();
                        $response['status'] = true;
                        $response['message'] = Config::get('message-constants.Password_changed');
                        $response['data'] = $user;
                        return response()->json($response);
                    } else {
                        $response['status'] = false;
                        $response['message'] = Config::get('message-constants.Current_password_wrong');
                        $response['data'] = (object) [];
                        return response()->json($response);
                    }
                }
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }

    public function getProfile()
    {
        try {

            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            $user = User::find($userId);
            $user->notification_count = unreadNotificationCount($userId);
            if (!$user) {
                return response()->json(['status' => false, 'message' => Config::get('message-constants.User_not_exist'), 'data' => (object) []]);
            } else {
                return response()->json(['status' => true, 'message' => Config::get('message-constants.Success'), 'data' => $user]);
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }


    public function deleteAccount(Request $request)
    {
        try {
            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            $validator = Validator::make($request->all(), [
                // 'email' => 'required|email|string',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                $response['status'] = false;
                $response['message'] = $validator->errors()->first();
                $response['data'] = (object) [];
                return response()->json($response);
            } else {

                $user = User::where(['id' => $userId])->first();
                if (!$user) {
                    return response()->json(['status' => false, 'message' => Config::get('message-constants.User_not_exist'), 'data' => (object) []]);
                } else {
                    if (Hash::check($request->password, $user->password)) {

                        $isDeleted = delete_user_account($userId, "USER");

                        if ($isDeleted) {
                            return response()->json(['status' => true, 'message' => Config::get('message-constants.Ac_delete_success'), 'data' => (object) []]);
                        } else {
                            return response()->json(['status' => false, 'message' => Config::get('message-constants.AC_delete_error'), 'data' => (object) []]);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => Config::get('message-constants.Wrong_credentials'), 'data' => (object) []]);
                    }
                }
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }




    public function OtpVerify(Request $request)
    {

        try {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp'   => 'required|min:6|max:6'
            ]);
            if ($validator->fails()) {
                $response['status']  = false;
                $response['message'] = $validator->errors()->first();
                $response['data']    = (object) [];
                return response()->json($response);
            } else {

                $user = User::where('email', $data['email'])->first();
                if (!$user) {
                    return response()->json(['status' => false, 'message' => Config::get('message-constants.User_not_exist'), 'data' => (object) []]);
                }
                $userOtp = UserOtp::where(['email' => $user->email, 'otp' => $request->otp])->first();

                if ($userOtp) {

                    $current_time = date('Y-m-d H:i:s');
                    $otp_expiry = date('Y-m-d H:i:s', strtotime($userOtp->opt_expiry));

                    // if (strtotime($current_time) > strtotime($otp_expiry)) {
                    //     $message = "OTP expired please resend OTP.";
                    //     return response()->json(['status' => false, 'message' => $message, 'data' => (object) []]);
                    // }

                    if ($user->status == 0) {
                        return response()->json(['status' => false, 'message' => Config::get('message-constants.Account_deactivated'), 'data' => (object) []]);
                    } else {
                        //delete OTP.
                        UserOtp::where('email', $user->email)->delete();
                        return response()->json(['status' => true, 'message' => Config::get('message-constants.OTP_verified'), 'data' => $user]);
                    }
                } else {
                    $message = Config::get('message-constants.Valid_OTP');
                    return response()->json(['status' => false, 'message' => $message, 'data' => (object) []]);
                }
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }

    public function UpdateDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'device_unique_id'   => 'required',
            'device_type'        => 'required',
            'device_token'       => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "false", 'message' => $validator->errors()->first()]);
        }
        try {

            $user_id = JWTAuth::toUser(JWTAuth::getToken())->id;

            $user_token = UserDevice::where('user_id', $user_id)
                ->where('device_unique_id', $request->device_unique_id)
                ->first();
            if ($user_token) {

                $user_token->device_token = $request->device_token;
                $user_token->save();
                $message = Config::get('message-constants.User_exist');
                return response()->json(['status' => true, 'message' => $message, 'data' => (object) []]);
            } else {
                $device = new UserDevice;
                $device->user_id           = $user_id;
                $device->device_unique_id         = $request->device_unique_id;
                $device->device_type       = $request->device_type;
                $device->device_token      = $request->device_token;
                $device->save();


                $message = Config::get('message-constants.TOKEN_UPDATED');
                return response()->json(['status' => true, 'message' => $message, 'data' => (object) []]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
                'data'    => (object)[]
            ]);
        }
    }


    

}
