<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class YearController extends Controller
{
    public function index(Request $request)
    {
        $title = "Year List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {

            $data = Year::orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // STATUS TOGGLE SWITCH
                ->editColumn('status', function ($row) {
                    $status = ($row->status == 1) ? 'checked="checked"' : '';
                    return '<label class="switch"><input type="checkbox" ' . $status . ' class=" toggle-status togbtn" data-id=' . $row->id . ' id="togBtn"><div class="slider round"> <span class="on">Active</span>  <span class="off">Inactive</span></div></label>';
                })

                // ACTION BUTTONS
                ->editColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-index" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                                <a class="dropdown-item delete-index" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    ';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('m/d/Y') : '';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.year.index', compact('title', 'breadcrumbs'));
    }

    public function add(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'year' => 'required|integer|digits:4|unique:years,year',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $year = new Year();
            $year->year = $request->year;
            $year->status = true; // default active
            $year->save();

            return response()->json([
                'status' => true,
                'message' => 'Year added successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request.'
        ], 405);
    }

    public function editData($id)
    {
        try {
            $year = Year::findOrFail($id);
            return response()->json($year);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $year = Year::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'year' => 'required|integer|digits:4|unique:years,year,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $year->year = $request->year;
            // status NOT updated here
            $year->save();

            return response()->json([
                'status' => true,
                'message' => 'Year updated successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request.'
        ], 405);
    }

    public function delete($id)
    {
        try {
            $year = Year::findOrFail($id);
            $year->delete();

            return response()->json([
                'status' => true,
                'message' => 'Year deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Delete failed.'
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $year = Year::findOrFail($id);
        $year->status = $request->status;
        $year->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
}
