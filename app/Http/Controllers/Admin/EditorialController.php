<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Editorial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class EditorialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Editorial::select('editorials.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" '.$checked.' class="status-toggle" data-id="'.$row->id.'">
                                <span class="slider"></span>
                            </label>';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="'.url($row->image).'" width="50">';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item view-editorial" href="javascript:void(0)" data-id="'.$row->id.'">View</a>
                            <a class="dropdown-item edit-editorial" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>
                            <a class="dropdown-item delete-editorial" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['status','image','action'])
                ->make(true);
        }

        $title = "Editorial List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        return view('admin.editorial.index', compact('title'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'type'         => 'required|string|max:50',
            'university'   => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        try {
            $imageFile = null;

            if ($request->hasFile('image')) {
                $destinationPath = 'public/uploads/editorials/';
                ensureDirectoryExists(base_path($destinationPath));
                $imageFile = uploadImage($request->image, $destinationPath);
            }

            Editorial::create([
                'name'        => $request->name,
                'type'        => $request->type,
                'university'  => $request->university,
                'description' => $request->description,
                'image'       => $imageFile,
                'status'      => 1
            ]);

            return response()->json(['success' => true, 'message' => 'Editorial added successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function editData($id)
    {
        $data = Editorial::find($id);

        if (!$data)
            return response()->json(['success' => false, 'message' => 'Not found'], 404);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'type'         => 'required|string|max:50',
            'university'   => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        try {
            $editorial = Editorial::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($editorial->image && File::exists(public_path($editorial->image))) {
                    File::delete(public_path($editorial->image));
                }
                $destinationPath = 'public/uploads/editorials/';
                $editorial->image = $this->uploadImage($request->image, $destinationPath);
            }

            $editorial->update([
                'name'        => $request->name,
                'type'        => $request->type,
                'university'  => $request->university,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $editorial = Editorial::findOrFail($id);

            if ($editorial->image && File::exists(public_path($editorial->image))) {
                File::delete(public_path($editorial->image));
            }

            $editorial->delete();

            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function updateStatus($id)
    {
        try {
            $editorial = Editorial::findOrFail($id);
            $editorial->status = $editorial->status == 1 ? 0 : 1;
            $editorial->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated',
                'status' => $editorial->status
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error'], 500);
        }
    }

    private function uploadImage($image, $destinationPath)
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(base_path($destinationPath), $imageName);
        return str_replace('public/', '', $destinationPath) . $imageName;
    }

    private function ensureDirectoryExists($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
    }
}
