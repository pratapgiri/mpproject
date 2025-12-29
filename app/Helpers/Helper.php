<?php

use App\Models\ApiLog;
use App\Models\Setting;
use App\Models\UserDevice;
use App\Models\User;
use App\Models\DeletedUser;
use App\Models\Notification;
use App\Models\UserOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


function ApiLog($user_id = 1, $url = '', $request = '')
{
    $apiLog = new ApiLog();
    $apiLog->user_id = $user_id;
    $apiLog->uri = $url;
    $apiLog->request = json_encode($request);
    $apiLog->save();
    return true;
}


function CatchResponse($e)
{
    return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => (object) []
    ]);
}

// Check if email exists
function checkEmailExist($email)
{
    return User::where('email', $email)->exists();
}

// Check if mobile number exists
function checkMobileExist($mobile_number, $country_code)
{
    return User::where('country_code', $country_code)
        ->where('mobile_number', $mobile_number)
        ->exists();
}


function verifyOtp(array $data)
{
    if (isset($data['email'])) {
        return UserOtp::where(['email' => $data['email'], 'otp' => $data['otp']])->first();
    }

    if (isset($data['mobile_number'])) {
        return UserOtp::where(['country_code' => $data['country_code'], 'mobile_number' => $data['mobile_number'], 'otp' => $data['otp']])->first();
    }

    return null;
}

function isOtpExpired(UserOtp $otp)
{
    $current_time = Carbon::now();
    $otp_expiry = Carbon::parse($otp->otp_expiry);

    return $current_time->gt($otp_expiry);
}



//optmional field
function processOptionalFields($request, &$data)
{


    if ($request->has('country_code')) {
        $data['country_code'] = $request->country_code;
    }
    if ($request->has('mobile_number')) {
        $data['mobile_number'] = $request->mobile_number;
    }

    if ($request->has('dob')) {
        $data['dob'] =  $request->dob;
    }
    if ($request->has('bio')) {
        $data['bio'] =  $request->bio;
    }

    if ($request->has('address')) {
        $data['address'] = $request->address;
        $data['latitude'] = $request->latitude ?? null;
        $data['longitude'] = $request->longitude ?? null;
    }
}



/**
 * Handle the file upload for the profile picture
 */
function handleProfilePictureUpload($user, $request, &$data)
{
    // Remove the existing profile picture file

    if ($request->hasFile('profile_picture')) {
        // Delete the old profile picture if it exists
        if ($user->profile_picture && file_exists(public_path(str_replace('public/', '', $user->profile_picture)))) {
            unlink(public_path(str_replace('public/', '', $user->profile_picture)));
        }
        // Process the new profile picture upload
        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/profile_picture'), $imageName);
        $data['profile_picture'] = 'public/uploads/profile_picture/' . $imageName;
    }
}


function ensureDirectoryExists($path)
{
    // dd($path);
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}
function uploadImage($image, $destinationPath = 'public/uploads/user/')
{
    $random = rand(111111, 9999999);
    $imageName = time() . $random . '.' . $image->extension();
    $image->move(base_path($destinationPath), $imageName);

    return $destinationPath . $imageName;
}


function base_url($url = "")
{

    $url = (string)$url;
    return  str_replace("public", "", url($url));
}

function setting($key = null)
{
    if ($key) {
        $setting = Setting::where('field_name', $key)->first();
        if ($setting) {
            return $setting->value;
        } else {
            return '';
        }
    } else {
        return '';
    }
}

function chkAuthToken($token)
{
    $chkToken = Setting::whereRaw("field_name='auth_token' AND value='" . $token . "' ")->count();
    if ($chkToken > 0) {
        return $chkToken;
    } else {
        return false;
    }
}

function is_valid_auth_token()
{
    $headers = apache_request_headers();
    $return_value = false;
    if (array_key_exists('auth_token', $headers)) {

        $auth_token = $headers['auth_token'];

        $check = chkAuthToken($auth_token);

        if (!empty($check) && $check == 1) {

            $return_value = true;
        }
    }
    return $return_value;
}

function generateEmailOTP()
{

    $setting = Setting::where('field_name', 'smtp_bypass')->first();

    if ($setting->value == '1') {
        $otp = 123456;
    } else {
        $otp = mt_rand(100000, 999999);
    }
    return $otp;
}


function delete_user_account($userId, $type)
{

    $user = User::find($userId);
    $deletedAccountData = ['name' => $user->user_name, 'email' => $user->email, 'deleted_by' => $type];

    //delete user data from all the related table
    UserDevice::where('user_id', $userId)->delete();
    //unlink profile image
    if (file_exists($user->profile_picture)) {
        unlink($user->profile_picture);
    }

    if ($user->delete()) {
        DeletedUser::create($deletedAccountData);

        return 1;
    } else {
        return 0;
    }
}

function insertConversation($data)
{
    $created_at = Carbon::now()->format('Y-m-d H:i:s');

    DB::table('conversations')->insert([
        'user_id'      => $data['user_id'],
        'other_user_id' => $data['other_user_id'],
        'type'         => $data['type'],
        // 'message_type' => $data['message_type'],
        // 'message'      => $data['message'],
        'created_at'   => $created_at,
        'updated_at'   => $created_at,
    ]);
}
function unreadNotificationCount($user_id)
{

    $user = User::find($user_id);

    $notification_count_1 = Notification::where(['user_id' => $user_id, 'is_seen' => 0])->where('type', '<>', 'BROADCAST_MESSAGE_ALL')->count();

    $notification_count_2 = Notification::where('type', 'BROADCAST_MESSAGE_ALL')->where('created_at', '>=', $user->created_at)->whereNotIn('id', function ($query) use ($user_id) {
        $query->select('notification_id')->from('seen_broadcast_notifications')->where(['user_id' => $user_id]);
    })->count();

    $totalUnreadNotifications = $notification_count_1 + $notification_count_2;

    return $totalUnreadNotifications;
}

function saveNotificationData($values)
{
    $user_ids = is_array($values['user_id']) ?  $values['user_id'] : explode(',', $values['user_id']);
    $cleaned_users = array_map(function ($user_ids) {
        return trim($user_ids, "[]");
    }, $user_ids);
    $user_ids = array_map('strval', $user_ids);
    foreach ($user_ids as $usersId) {
        $notification = new Notification();
        $notification->sender_id = $values['sender_id'] ?? 0;
        $notification->user_id = $usersId;
        $notification->type = $values['type'];
        $notification->title =  $values['title'];
        $notification->message =  $values['message'];
        $notification->data = json_encode($values);
        $notification->save();
    }
    $values['user_id'] = $user_ids;
    sendNotification($values);
}
// Send notification using firebase.
function sendNotification($data)
{
    if ($data['user_id'] != "") {
        // dd( $data['user_id'] );

        $query = UserDevice::whereHas('user', function ($q) {
            $q->where('notification_status', 1);
        });
        if (is_array($data['user_id'])) {
            $FcmUserToken = $query->whereIn('user_id', $data['user_id'])->whereNotNull('device_token')->where('device_token', '<>', " ")->pluck('device_token')->all();
        } else {
            $FcmUserToken = $query->where('user_id', $data['user_id'])->whereNotNull('device_token')->pluck('device_token')->all();
        }
        // dd( $FcmUserToken );

        if (!empty($FcmUserToken)) {

            $extra = $data;

            $extra = [];
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $extra[$key] = $value;
                } else {
                    $extra[$key] = json_encode($value);
                }
            }


            $firebase = (new Factory)
                ->withServiceAccount(public_path() . '/fcm_notification.json');

            $messaging = $firebase->createMessaging();

            $message = CloudMessage::fromArray([
                'notification' => [
                    "title" => $data['title'],
                    "body" => $data['message'],
                ],
                'data' => $extra
            ]);

            $res = $messaging->sendMulticast($message, $FcmUserToken);

            // // Process the result
            $successful = $res->successes()->count();
            $failed = $res->failures()->count();

            $failures = $res->failures()->map(function ($failure) {
                return [
                    'token' => $failure->target(),
                    'error' => $failure->error()->getMessage(),
                ];
            });

            $result = json_encode([
                'successful' => $successful,
                'failed' => $failed,
                'failures' => $failures,
            ]);

            // dd( $result);

            // \Log::info($result);
        }
    }
}
