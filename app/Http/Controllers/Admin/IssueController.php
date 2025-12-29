<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $year = Year::where('status', true)->get();
        if ($request->ajax()) {

            $data = Issue::orderBy('created_at', 'desc')->with('year')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {
                    $badge = $row->status ? 'success' : 'danger';
                    $text = $row->status ? 'Active' : 'Inactive';

                    return '<span class="badge badge-' . $badge . ' status-toggle"
                            data-id="' . $row->id . '" 
                            data-status="' . $row->status . '" 
                            style="cursor:pointer;">' . $text . '</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-index" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                                <a class="dropdown-item delete_index" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    ';
                })
                ->editColumn('year', function ($row) {
                    return $row->year->year;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('m/d/Y H:i');
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $title = "Issues List";
        $breadcrumbs = [['name' => $title, 'relation' => 'Current', 'url' => '']];

        return view('admin.issue.index', compact('title', 'breadcrumbs', 'year'));
    }


    public function add(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'year' => 'required|max:45',
                'issues' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }

            Issue::create([
                'year_id' => $request->year,
                'issues' => $request->issues,
                'status' => 1
            ]);

            return response()->json(['status' => true, 'message' => "Issue added successfully."]);
        }
    }


    public function editData($id)
    {
        $data = Issue::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => "Issue not found."], 404);
        }

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'year' => 'required|max:45',
                'issues' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
            }

            $issue = Issue::findOrFail($id);
            $issue->update($request->only('year', 'issues'));

            return response()->json(['status' => true, 'message' => "Issue updated successfully."]);
        }
    }


    public function delete($id)
    {
        try {
            Issue::findOrFail($id)->delete();
            return response()->json(['status' => true, 'message' => "Issue deleted successfully."]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Error deleting issue."], 500);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            $issue = Issue::findOrFail($id);
            $issue->status = $request->status;
            $issue->save();

            return response()->json(['status' => true, 'message' => "Status updated successfully."]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Error updating status."], 500);
        }
    }


    public function getIssuesByYear($id)
    {
        try {
            $issues = Issue::where('year_id', $id)->where('status', true)->get();
            return response()->json($issues);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load issues'], 500);
        }
    }
}
