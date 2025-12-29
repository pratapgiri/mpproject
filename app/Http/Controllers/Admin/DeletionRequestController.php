<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeleteRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DeletionRequestController extends Controller
{


    public function index(Request $request)
    {

        $title = "Account Deletion Requests";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $data = DeleteRequest::latest()->get();
            $table = DataTables::of($data)

                ->addIndexColumn()
                ->editColumn('action', function ($row) {

                    $btn = '<div class="action-width"><button class="btn btn-danger btn-sm ml-2 delete_account" data-id="' . $row->id . '"><i class="icon-trash" aria-hidden="true"></i></button></div>';

                    return $btn;
                })
                ->editColumn('description', function ($row) {
                    return '<td><input type="hidden" class="description" value="' . $row->reason . '" /><button type="button" class="btn btn-primary viewDescriptionBtn" data-toggle="modal" data-target="#viewDescriptionBtn">View Reason</button></td>';
                })
                ->editColumn('name', function ($row) {
                    return  "$row->name";
                })
                ->editColumn('created_at', function ($row) {
                    return '<td>' . $row->created_at->format('m/d/Y') . '</td>';
                })

                ->rawColumns(['action', 'description', 'created_at'])
                ->make(true);

            return $table;
        }
        return view('admin/account-delete-request/index', compact('title', 'breadcrumbs'));
    }


    public function deleteUserAccount($id)
    {
        $deleteRequest = DeleteRequest::find($id);
        $user = User::where(['email' => $deleteRequest->email])->first();
        if ($user) {

            $isDeleted = delete_user_account($user->id, "ADMIN");

            if ($isDeleted) {

                //delete request from DB.
                $deleteRequest->delete();

                // return redirect('/admin/account-deletion-requests')->with('success_msg',  $user->user_name . ' account has been deleted!');
                return redirect()->back()->with('success_msg',  $user->user_name . ' account has been deleted.');
            } else {
                return redirect()->back()->with('error_msg', 'Something went wrong while deleting account, Please try again.');
            }
        } else {
            return redirect()->back()->with('error_msg', 'User account does not exist.');
        }
    }
}
