<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\Uploader;
use App\Models\User;
use App\Lib\Email;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function userList(Request $request)
    {

        $title = "User List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $query = User::latest();

            // Filter based on status
            if ($request->has('status') && $request->status != NULL) {
                $query->where('status', (int)$request->status);
            }

            if ($request->has('subscribe') && $request->subscribe != NULL) {
                $query->where('is_premium', $request->subscribe);
            }

            $data = $query->get();

            $table = DataTables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="' . url('admin/users/view/' . $row->id) . '">View</a>
                                </div>
                            </div>';
                    //<a class="dropdown-item" href="' . url('admin/users/edit/' . $row->id) . '">Edit</a>
                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    $status = ($row->status == 1) ? 'checked="checked"' : '';
                    return '<label class="switch"><input type="checkbox" ' . $status . ' class="togbtn" data-id=' . $row->id . ' id="togBtn"><div class="slider round"> <span class="on">Active</span>  <span class="off">Inactive</span></div></label>';
                })
                ->editColumn('created_at', function ($row) {
                    return '<td>' . $row->created_at->format('m/d/Y') . '</td>';
                })

                ->editColumn('subscription_status', function ($row) {
                    $subscription_status = ($row->is_premium == '1') ? 'Premium' : 'Free';
                    return $subscription_status;
                })

                ->rawColumns(['action', 'status', 'created_at', 'subscription_status'])
                ->make(true);

            return $table;
        }
        return view('admin/user/index', compact('title', 'breadcrumbs'));
    }


    public function status(Request $request)
    {
        $id = $request->id;
        $row = User::whereId($id)->first();
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        if ($row->status) {
            $email_data['link'] = '<h2>Hello, ' . $row->user_name . '</h2>';
            $email_data['link'] .= '<h3>Your account has been activated. You can now login.</h3>';

            Email::send('account-active-inactive', $email_data, $row->email, "Account Activation");
        } else {
            $email_data['link'] = '<h2>Hello, ' . $row->user_name . '</h2>';
            $email_data['link'] .= '<h3>Your account has been deactivated, please contact to administrator.</h3>';

            Email::send('account-active-inactive', $email_data, $row->email, "Account Deactivation");
        }

        return response()->json(['success' => 'User status changed successfully.', 'val' => $row->status]);
    }

    public function viewUser($id)
    {
        $title = "View User";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        $user = User::find($id);
        if ($user) {
            return view('admin/user/view-user', compact('title', 'breadcrumbs', 'user'));
        } else {
            // return abort(404, 'Page not found.');
            return redirect('admin/users-list')->with('error_msg', "user does not exist.");
        }
    }

    public function edit($id)
    {
        $title = "Edit User";
        $breadcrumbs = [
            ['name' => 'Edit User', 'relation' => 'Current', 'url' => '']
        ];

        $user = User::find($id);
        if ($user) {
            return view('admin/user/edit', compact('title', 'breadcrumbs', 'user'));
        } else {
            return redirect('admin/users-list')->with('error_msg', "user does not exist.");
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_name' => 'required|max:80',
                // 'email' => 'required|email|unique:users,email,' . $id . ',id',
                'password' => 'nullable|confirmed',
                'country_code' => 'nullable',
                'mobile' => 'nullable|numeric',
                'profile_picture' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
                'status' => 'required|in:0,1',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                    if (!isset($firstError))
                        $firstError = $messages[0];
                    $error[$field_name] = $messages[0];
                }
                return response()->json(array(
                    'errors' => $validator->messages()
                ), 422);
            } else {

                $user = User::find($id);
                $data = [
                    'user_name' => $request->user_name,
                    // 'email' => $request->email,
                    'country_code' => $request->country_code,
                    'mobile' => $request->mobile,
                    'mobile_number' => str_replace("+", "", $request->country_code) . $request->mobile,
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ];

                if ($request->has('password') && $request->password != NULL) {
                    $data['password'] = Hash::make($data['password']);
                }


                if ($request->hasFile('profile_picture')) {

                    //unlink already exist image
                    if (file_exists($user->profile_picture)) {
                        unlink($user->profile_picture);
                    }

                    $destinationPath = '/uploads/profile/';
                    $responseData = Uploader::doUpload($request->file('profile_picture'), $destinationPath, true);
                    if ($responseData['status'] == "true") {
                        $data['profile_picture'] = $responseData['file'];
                    }
                }


                $affected = $user->update($data);

                if ($affected) {
                    return ['status' => 'true', 'message' => __("User data updated successfully.")];
                } else {
                    return ['status' => 'true', 'message' => __("Something went wrong, Please try again.")];
                }
            }
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage()];
        }
    }

    public function deleteAccount($id)
    {
        $user = User::find($id);
        if ($user) {

            $isDeleted = delete_user_account($user->id, "ADMIN");

            if ($isDeleted) {
                return redirect()->back()->with('success_msg',  $user->user_name . ' account has been deleted.');
            } else {
                return redirect()->back()->with('error_msg', 'Something went wrong while deleting account, Please try again.');
            }
        } else {
            return redirect()->back()->with('error_msg', 'User account does not exist.');
        }
    }
}
