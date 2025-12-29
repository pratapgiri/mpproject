<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;

class BroadcastController extends Controller
{
    public function index(Request $request)
    {
        $title = "Broadcast";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];
        if ($request->ajax() && $request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'send_to' => 'required',
                'user_ids'  => 'required_if:send_to,==,selected_users',
                'title'     => 'required',
                'body'      => 'required'
            ], [
                'user_ids.required_if' => 'Please select users.',
            ]);
            if ($validator->fails()) {

                return response()->json(['status' => false, 'error' => $validator->messages()], 200);
            }

            if ($request->send_to == 'all_users') {

                //Send notification
                $notification_arr = [
                    'user_id' => 0,
                    'sender_id' => 0,
                    'title' => $request->title,
                    'type' => 'BROADCAST_MESSAGE_ALL',
                    'message' => $request->body,
                ];
                Notification::create($notification_arr);

                $users_id = User::active()->latest()->pluck('id')->toArray();

                $notification_arr['user_id'] = $users_id;
            } else {

                foreach ($request->user_ids as $usersId) {

                    //Send notification
                    $notification_arr = [
                        'user_id' => $usersId,
                        'sender_id' => 0,
                        'title' => $request->title,
                        'type' => 'BROADCAST_MESSAGE_SPECIFIC_USER',
                        'message' => $request->body,
                    ];
                    Notification::create($notification_arr);
                }

                $notification_arr['user_id'] = $request->user_ids;
            }
            sendNotification($notification_arr);
            return response()->json(['status' => true, 'success' => 'Broadcast Message sent successfully.']);
        }

        $users = User::active()->latest()->get();

        return view('admin/broadcast/index', compact('title', 'breadcrumbs', 'users'));
    }
}
