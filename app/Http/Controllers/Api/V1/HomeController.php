<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\VersionControlSetting;
use Carbon\Carbon;
use Exception;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function getAuthToken(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'access_token' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json([
                    'status' => false,
                    'message' => $error,
                    'data' => (object) []
                ]);
            } else {
                $access_token = Config::get('message-constants.AUTH_TOKEN_ACCESS_KEY');
                if ($access_token == $request->access_token) {

                    $auth = Setting::select('value')->where('field_name', 'auth_token')->first();
                    return response()->json(['status' => true, 'message' => Config::get('message-constants.AUTH_TOKEN_SUCCESS'), 'data' => $auth]);
                } else {

                    return response()->json(['status' => false, 'message' => Config::get('message-constants.AUTH_TOKEN_INVALID'), 'data' => (object) []]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => (object) []]);
        }
    }


    public function userlist()
    {
        try {

            $user = User::where('status', 1)->get();
            if (!$user) {
                return response()->json(['status' => false, 'message' => Config::get('message-constants.User_not_exist'), 'data' => (object) []]);
            } else {
                return response()->json(['status' => true, 'message' => Config::get('message-constants.Success'), 'data' => $user]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => (object) []]);
        }
    }




    public function uploadChatMedia(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chat_media'  => 'required',
                'media_type' => 'required|in:VIDEO,IMAGE,AUDIO',
            ]);

            DB::table('api_logs')->insert([
                'user_id' => 1,
                'request' => json_encode($request->all())
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 400);
            }


            // $file = $request->file('chat_media');
            // $extension = $file->getClientOriginalExtension();
            $timestamp = time();
            // $folderPath = public_path('uploads/chatmedia');

            // // Ensure the directory exists
            // if (!file_exists($folderPath)) {
            //     mkdir($folderPath, 0777, true);
            // }

            // $filename = $timestamp . '.' . $extension;
            // $filePath = $folderPath . '/' . $filename;
            // $file->move($folderPath, $filename);

            if ($request->file('chat_media')) {
                $destinationPath = '/public/uploads/chatmedia/';
                $imagePath = $request->file('chat_media');
                $image = uploadImage($imagePath, $destinationPath);
            }
            $data = [
                'media'       => $image,
                'media_thumb' => null,
            ];

            if ($request->media_type === 'VIDEO') {
                // Instantiate FFMpeg
                $ffmpeg = FFMpeg::create();

                // Open the video file
                $video = $ffmpeg->open($image);

                // Generate a thumbnail for the video
                $thumbnailFilename = $timestamp . '.jpg';
                $thumbnailPath = $destinationPath . '/' . $thumbnailFilename;

                // Generate a thumbnail at the 1-second mark
                $video->frame(TimeCode::fromSeconds(1))
                    ->save($thumbnailPath);

                $data['media_thumb'] = ("/public/uploads/chatmedia/$thumbnailFilename");
            }

            return response()->json([
                'status'  => true,
                'message' => 'Media chat uploaded successfully',
                'data'    => $data,
            ], 200);
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }

    public function versionControl()
    {
        try {
            $getSetting = VersionControlSetting::select('field_name', 'value')->get();
            $versionControlSetting = [];
            foreach ($getSetting as $setting) {
                $versionControlSetting[$setting['field_name']] = $setting['value'];
            }
            return response()->json([
                'status' => true,
                'message' => Config::get('message-constants.VERSION_CONTROL_SUCCESS'),
                'data' => $versionControlSetting
            ]);
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }
}
