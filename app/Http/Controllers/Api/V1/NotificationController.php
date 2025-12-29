<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClearedBroadcastNotification;
use App\Models\Notification;
use App\Models\SeenBroadcastNotification;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{


    public function sendChatNotification(Request $request)
    {
        try {
            $chatId =  $request->insertId;
            $chatData = DB::table('chats')->where('id', $chatId)->first();
            if (empty($chatData)) {
                echo "Data not found";
                exit();
            }
            $otherUserId = $chatData->other_user_id;
            $user_chat_screen = DB::table('user_chat_screen')
                ->where('user_id', $chatData->other_user_id)
                ->where('other_user_id', $chatData->user_id)
                ->first();

            if ($user_chat_screen) {
                exit();
            }
            $userIds = $otherUserId;
            $other_data = User::where('id', $chatData->user_id)->first();

            $value = [
                'sender_id' => $chatData->user_id,
                "user_id" =>  $userIds,
                'title' =>  'Someone sent a message',
                "type" => "SEND_MSG_" . $chatData->type,
                "message" =>  $chatData->message,
                "other_data" =>  $other_data,

            ];
            // dd($value);
            echo '<pre>';
            echo json_encode($value, JSON_PRETTY_PRINT);
            // print_r($value);
            sendNotification($value);
        } catch (Exception $e) {
            return CatchResponse($e);
        }
    }



    public function clearNotification(Request $request)
    {
        try {

            $user = JWTAuth::toUser(JWTAuth::getToken());
            $userId = $user->id;

            $validator = Validator::make($request->all(), [
                'notification_id' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $response['message'] = $validator->errors()->first();
                $response['data'] = (object) [];
                return response()->json($response);
            } else {

                $whereArr = [
                    'user_id' => $userId,
                ];

                if ($request->has('notification_id') && $request->notification_id != "") {
                    $whereArr['id'] = $request->notification_id;

                    $notification = Notification::where($whereArr)->first();

                    if (!$notification) {
                        return response()->json(['status' => false, 'message' => Config::get('message-constants.No_Notification'), 'data' => (object) []]);
                    }
                }

                Notification::where($whereArr)->where('type', '<>', 'BROADCAST_MESSAGE_ALL')->delete();


                //To clear broadcast notification
                $query = Notification::where('type', 'BROADCAST_MESSAGE_ALL')
                    ->where('created_at', '>=', $user->created_at);


                if ($request->has('notification_id') && $request->notification_id != "") {
                    $query->where('id', $request->notification_id);
                }

                $broadcastNotification = $query->whereNotIn('notifications.id', function ($query) use ($user) {
                    $query->select('notification_id')->from('cleared_broadcast_notifications')->where('user_id', $user->id)->get();
                })
                    ->get()
                    ->pluck('id');

                foreach ($broadcastNotification as $broadcast_notification) {
                    ClearedBroadcastNotification::create([
                        'user_id' => $userId,
                        'notification_id' => $broadcast_notification,
                    ]);
                }

                return response()->json(['status' => true, 'message' => Config::get('message-constants.Notification_clear'), 'data' => (object) []]);
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }

    public function notificationList(Request $request)
    {

        // ApiLog(1, 'notificationList', $request->all());

        try {

            $limit = 10;

            $userLogged = JWTAuth::toUser(JWTAuth::getToken());

            $result = Notification::where(function ($query) use ($userLogged) {
                $query->where('user_id', $userLogged->id);
                $query->orWhere('type', 'BROADCAST_MESSAGE_ALL');
            })
                ->whereNotIn('notifications.id', function ($query) use ($userLogged) {
                    $query->select('notification_id')->from('cleared_broadcast_notifications')->where('user_id', $userLogged->id)->get();
                })
                ->where('created_at', '>=', $userLogged->created_at)
                ->with('user')->orderBy('id', 'DESC')->paginate($limit);
            //only insert broadcast notification, other entires will manage by is_seen key
            foreach ($result as $notification) {
                if ($notification->type == 'BROADCAST_MESSAGE_ALL') {
                    SeenBroadcastNotification::updateOrCreate([
                        'user_id' => $userLogged->id,
                        'notification_id' => $notification->id,
                    ]);
                } else {

                    //update is_seen for all the notification other then BROADCAST_MESSAGE.
                    $notification->update(['is_seen' => 1]);
                }
            }


            return response()->json(['status' => true, 'message' => Config::get('message-constants.Success'), 'data' => $result]);
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }


    public function updateNotificationStatus(Request $request)
    {
        try {
            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            $validator = Validator::make($request->all(), [
                'status_key' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                $response['status'] = false;
                $response['message'] = $validator->errors()->first();
                $response['data'] = (object) [];
                return response()->json($response);
            } else {

                $user_data = User::find($userId);
                $user_data->update(["notification_status" => (int) $request->status_key]);

                return response()->json([
                    'status' => true,
                    'message' => Config::get('message-constants.Notification_status'),
                    'data' => $user_data
                ]);
            }
        } catch (\Exception $e) {
            return CatchResponse($e);
        }
    }
}
