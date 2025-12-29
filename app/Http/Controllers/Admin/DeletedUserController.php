<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeletedUser;
use Yajra\DataTables\Facades\DataTables;

class DeletedUserController extends Controller
{

    public function index(Request $request)
    {
        $title = "Deleted Accounts";

        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {

            $list = DeletedUser::query();

            $list = $list->orderBy('created_at', 'desc')->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return '<td>' . $row->created_at->format('m/d/Y') . '</td>';
                })
                ->rawColumns(['created_at'])
                ->make(true);
        }

        return view('admin/deleted-user/index', compact('title', 'breadcrumbs'));
    }
}
