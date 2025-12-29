<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\Uploader;
use App\Models\User;
use App\Models\ReportUser;

use Illuminate\Support\Facades\Validator;
use App\Lib\Email;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserReportController extends Controller
{
    public function status(Request $request)
    {
        $id = $request->id;
        $row = User::whereId($id)->first();
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return response()->json(['success' => 'User status changed successfully.', 'val' => $row->status]);
    }
    public function index(Request $request)
    {
        // dd('asas');
        $title = "Reported User List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $data = Report::selectRaw('other_user_id, COUNT(*) as total_reported_user, MAX(created_at) as latest_report')
                ->whereNotNull('other_user_id')
                ->whereHas('user_details')
                ->with('user_details')
                ->groupBy('other_user_id')
                ->orderByDesc('latest_report') // Order by the latest report date
                ->get();

            // dd($data);

            $table = DataTables::of($data)

                ->addIndexColumn()

                ->editColumn('user_name', function ($row) {
                    return '<td><a href="' . route('users.view', $row->user_details->id) . '" target="_blank" class="text-decoration-none text-reset">' . ucfirst($row->user_details->name) . '</a></td>';
                })

                ->editColumn('total_reported_user', function ($row) {
                    $userCount = $row->total_reported_user;
                    return '<td>' . $userCount . '</td>';
                })



                ->editColumn('status', function ($row) {
                    $status = ($row->user_details->status == 1) ? 'checked="checked"' : '';
                    return '<label class="switch"><input type="checkbox" ' . $status . ' class="togbtn" data-id=' . $row->user_details->id . ' id="togBtn"><div class="slider round"> <span class="on">Active</span>  <span class="off">Inactive</span></div></label>';
                })

                ->addColumn('action', function ($row) {
                    $btn = '<td><a href="' . url('admin/report_user/view/' . $row->user_details->id) . '"><button class="btn btn-primary btn-sm updateData"><i class="icon-eye" aria-hidden="true"></i></button></a></td>';
                    return $btn;
                })

                ->rawColumns(['user_name', 'total_reported_user', 'status', 'action'])
                ->make(true);

            return $table;
        }
        return view('admin/report_user/index', compact('title', 'breadcrumbs'));
    }

    public function view(Request $request, $user_id)
    {
        // dd('assa');
        $title = "Reported User Information";
        $breadcrumbs = [
            ['name' => 'Report User', 'relation' => 'link', 'url' => 'report_user'],
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $data = Report::latest()->with('user_details', 'reportUser')->where('other_user_id', $user_id)->get();
            $table = DataTables::of($data)

                ->addIndexColumn()

                ->editColumn('post_caption', function ($row) {
                    $status = $row->user_details->status ? 'Active' : 'Inactive';

                    return '<td><a href="javascript:void(0)" class="text-decoration-none text-reset">' . ucfirst($row->user_details->user_name) . '</a></td>';
                })

                ->editColumn('reporter', function ($row) {
                    return '<td><a href="' . url('admin/users/view/' . $row->reportUser->id) . '" target="_blank" class="text-decoration-none text-reset">' . ucfirst($row->reportUser->user_name) . '</a></td>';
                })
                ->editColumn('created_at', function ($row) {
                    return '<td>' . date('m/d/Y', strtotime($row->created_at)) . '</td>';
                })


                ->editColumn('description', function ($row) {
                    return '<td><input type="hidden" class="description" value="' . $row->reason . '" /><button type="button" class="btn btn-primary viewDescriptionBtn" data-toggle="modal" data-target="#viewDescriptionBtn">View Description</button></td>';
                })

                ->rawColumns(['post_caption', 'reporter', 'created_at', 'description'])
                ->make(true);

            return $table;
        }
        return view('admin/report_user/view', compact('title', 'breadcrumbs'));
    }
}
