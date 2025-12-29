<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // ==========================================
    // LIST + DATATABLE
    // ==========================================
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = News::orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                /* ->addColumn('status', function ($row) {
                    $badge = $row->status ? 'success' : 'danger';
                    $text = $row->status ? 'Active' : 'Inactive';

                    return '<span class="badge badge-' . $badge . ' status-toggle"
                                data-id="' . $row->id . '"
                                data-status="' . $row->status . '"
                                style="cursor:pointer;">
                                ' . $text . '
                            </span>';
                }) */
                ->editColumn('status', function ($row) {
                    $status = ($row->status == 1) ? 'checked="checked"' : '';
                    return '<label class="switch"><input type="checkbox" ' . $status . ' class=" status-toggle togbtn" data-id=' . $row->id . ' id="togBtn"><div class="slider round"> <span class="on">Active</span>  <span class="off">Inactive</span></div></label>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-news" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                                <a class="dropdown-item delete_news" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    ';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $title = "News List";
        return view('admin.news.index', compact('title'));
    }


    // ==========================================
    // ADD NEWS
    // ==========================================
    public function add(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:45',
                'description' => 'required|max:255',
                'status' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            News::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ?? 1
            ]);

            return response()->json([
                'status' => true,
                'message' => "News added successfully."
            ]);
        }
    }


    // ==========================================
    // GET SINGLE NEWS (FOR EDIT)
    // ==========================================
    public function editData($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => "News not found."
            ], 404);
        }

        return response()->json($news);
    }


    // ==========================================
    // UPDATE NEWS
    // ==========================================
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:45',
                'description' => 'required|max:255',
                'status' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $news = News::findOrFail($id);

            $news->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status ?? $news->status
            ]);

            return response()->json([
                'status' => true,
                'message' => "News updated successfully."
            ]);
        }
    }


    // ==========================================
    // DELETE NEWS
    // ==========================================
    public function delete($id)
    {
        try {
            News::findOrFail($id)->delete();

            return response()->json([
                'status' => true,
                'message' => "News deleted successfully."
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Error deleting news."
            ], 500);
        }
    }


    // ==========================================
    // UPDATE STATUS (TOGGLE)
    // ==========================================
    public function updateStatus(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);
            $news->status = $news->status ? 0 : 1;
            $news->save();

            return response()->json([
                'status' => true,
                'message' => "Status updated successfully."
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "Error updating status."
            ], 500);
        }
    }

}
 