<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallForPaper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CallForPaperController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CallForPaper::orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $badge = $row->status ? 'success' : 'danger';
                    $text = $row->status ? 'Active' : 'Inactive';
                    
                    // FIX: Ensure class matches JS listener if needed, though strict toggle uses data-id
                    return '<span class="badge badge-' . $badge . ' status-toggle"
                                data-id="' . $row->id . '"
                                data-status="' . $row->status . '"
                                style="cursor:pointer;">' . $text . '</span>';
                })
                ->addColumn('action', function ($row) {
                    // FIX: Changed classes to 'edit-call' and 'delete-call' to match JS
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-call" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                                <a class="dropdown-item delete-call" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>';
                })
                ->editColumn('date', function ($row) {
                    // FIX: Added Carbon parse to ensure no errors if model casting is missing
                    return $row->date ? Carbon::parse($row->date)->format('d-m-Y h:i A') : '';
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d-m-Y');
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $title = "Call For Papers List";
        return view('admin.call_for_papers.index', compact('title'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'nullable|date',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        CallForPaper::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'status' => $request->status ?? 1,
        ]);

        return response()->json(['status' => true, 'message' => "Call For Paper added successfully."]);
    }

    public function editData($id)
    {
        $data = CallForPaper::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => "Record not found"], 404);
        }

        // FIX: Format date specifically for HTML5 datetime-local input (Y-m-d\TH:i)
        if($data->date){
            $data->formatted_date = Carbon::parse($data->date)->format('Y-m-d\TH:i');
        } else {
            $data->formatted_date = '';
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'nullable|date',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $paper = CallForPaper::findOrFail($id);

        $paper->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return response()->json(['status' => true, 'message' => "Updated successfully."]);
    }

    public function delete($id)
    {
        try {
            CallForPaper::findOrFail($id)->delete();
            return response()->json(['status' => true, 'message' => "Deleted successfully."]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Error deleting record."], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $paper = CallForPaper::findOrFail($id);
            $paper->status = $request->status;
            $paper->save();

            return response()->json(['status' => true, 'message' => "Status updated"]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "Error updating status"], 500);
        }
    }
}