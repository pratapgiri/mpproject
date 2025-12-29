<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LogoController extends Controller
{
    public function index(Request $request)
    {
        $title = "Logo List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $data = Logo::orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    return '<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Actions</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item edit-index" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                        </div>
                    </div>';
                })
                ->editColumn('image', function ($row) {
                    return $row->image
                        ? "<img class='sm-img img-thumbnail' src='" . asset($row->image) . "'>"
                        : 'No Image';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('m/d/Y') : '';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.logo.index', compact('title', 'breadcrumbs'));
    }

    public function add(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:45|unique:logos,name',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'errors' => $validator->errors()
                ], 422);
            }

            $logo = new Logo();
            $logo->name = $request->name;

            if ($request->hasFile('image')) {

                $path = 'public/uploads/logos/';
                ensureDirectoryExists(public_path($path));

                $uploaded = uploadImage($request->image, $path);

                $logo->image = $uploaded;
            }

            $logo->save();

            return response()->json([
                'status' => 'true',
                'message' => 'Logo added successfully.'
            ]);
        }

        return response()->json([
            'status' => 'false',
            'message' => 'Invalid request.'
        ], 405);
    }

    public function editData($id)
    {
        try {
            $logo = Logo::findOrFail($id);
            return response()->json($logo);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'Record not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('post')) {

            $logo = Logo::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:45|unique:logos,name,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'errors' => $validator->errors()
                ], 422);
            }

            $logo->name = $request->name;

            if ($request->hasFile('image')) {

                // Remove old image
                if ($logo->image && file_exists(public_path($logo->image))) {
                    unlink(public_path($logo->image));
                }

                $path = 'public/uploads/logos/';
                ensureDirectoryExists(public_path($path));

                $uploaded = uploadImage($request->image, $path);

                $logo->image = $uploaded;
            }

            $logo->save();

            return response()->json([
                'status' => 'true',
                'message' => 'Logo updated successfully.'
            ]);
        }

        return response()->json([
            'status' => 'false',
            'message' => 'Invalid request.'
        ], 405);
    }

    public function delete($id)
    {
        try {
            $logo = Logo::findOrFail($id);

            if ($logo->image && file_exists(public_path($logo->image))) {
                unlink(public_path($logo->image));
            }

            $logo->delete();

            return response()->json([
                'status' => 'true',
                'message' => 'Logo deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'Delete failed.'
            ], 500);
        }
    }
}
