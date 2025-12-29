<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\DeleteRequest;
use App\Models\User;
use App\Models\Notifications;
use App\Lib\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{

    //To Load admin panel dashboard page
    public function index()
    {
        // dd('sddssd');
        $totalUsers = User::count();
        $activeUsers = User::active()->count();
        $title = "Dashboard";
        $breadcrumbs = [
            ['name' => 'Dashboard', 'relation' => 'Current', 'url' => '', 'icon' => 'fa fa-dashboard']
        ];

        return view('admin.home.dashboard', compact('title', 'breadcrumbs', 'totalUsers', 'activeUsers'));
    }
    public function profile(Request $request)
    {
        $title = "Profile";
        $breadcrumbs = [
            ['name' => 'Profile', 'relation' => 'Current', 'url' => '']
        ];
        $date = date('Y-m-d h:i:s', time());
        $data = Admin::find(Auth::guard('admin')->user()->id);

        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'name'             => 'required|max:45',
                    'profile_picture'  => 'nullable|mimes:jpeg,png,jpg,gif,svg'
                ]);

                if ($validator->fails()) {
                    foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                        if (!isset($firstError))
                            $firstError = $messages[0];
                        $error[$field_name] = $messages[0];
                    }

                    return response()->json(array('errors' => $validator->messages()), 422);
                } else {
                    $formData = ['name' => $request->get('name')];

                    // Check if a profile picture is provided
                    if ($request->hasFile('profile_picture')) {
                        $imageFile = $request->file('profile_picture');

                        // Ensure the image is valid
                        if ($imageFile->isValid()) {
                            $path = "public/uploads/admin/";
                            // Create the uploads directory if it doesn't exist
                            if (!file_exists(base_path($path))) {
                                mkdir(base_path($path), 0777, true);
                            }
                            // Check if the current profile picture exists and is a file, then delete it
                            $existingProfilePicture = public_path($data->profile_picture);
                            if (file_exists($existingProfilePicture) && !is_dir($existingProfilePicture)) {
                                unlink($existingProfilePicture); // Delete the old profile picture
                            }
                            // Set the form data for the profile picture path
                            $formData['profile_picture'] = uploadImage($imageFile, $path);
                        }
                    }
                    $data->update($formData);

                    return ['status' => 'true', 'message' => __("Profile updated successfully.")];
                }
            } catch (\Exception $e) {
                return ['status' => 'false', 'message' => $e->getMessage()];
            }
        }
        return view('admin.home.profile', compact('title', 'breadcrumbs', 'data'));
    }
    public function  changePassword(Request $request)
    {
        $title = "Change Password";
        $breadcrumbs = [
            ['name' => 'Change Password', 'relation' => 'Current', 'url' => '']
        ];
        if ($request->ajax() && $request->isMethod('post')) {

            try {
                $validator = Validator::make($request->all(), [
                    'current_password'      => 'required|max:45',
                    'new_password'          => 'required|max:45|min:8|same:confirm_password',
                    'confirm_password'      => 'required|max:45|min:8'
                ]);
                if ($validator->fails()) {
                    foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                        if (!isset($firstError))
                            $firstError = $messages[0];
                        $error[$field_name] = $messages[0];
                    }

                    return response()->json(array('errors' => $validator->messages()), 422);
                } else {
                    $data = Admin::find(Auth::guard('admin')->user()->id);
                    if (Hash::check($request->get('current_password'), $data->password)) {
                        $data->update(['password' => Hash::make($request->get('new_password'))]);

                        return ['status' => 'true', 'message' => __("Password updated successfully.")];
                    } else {

                        return ['status' => 'false', 'message' => __("Current password does't match.")];
                    }
                }
            } catch (\Exception $e) {
                return ['status' => 'false', 'message' => $e->getMessage()];
            }
        }
        return view('admin.home.change_password', compact('title', 'breadcrumbs'));
    }
}
