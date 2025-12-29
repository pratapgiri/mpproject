<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $title = "Index List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {
            $data = Index::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item edit-index" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                            <a class="dropdown-item delete_index" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->editColumn('image', function ($row) {
                    return $row->image ? "<img class='sm-img img-thumbnail' alt='index image' src='" . asset($row->image) . "'>" : 'No Image';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('m/d/Y');
                })
                ->rawColumns(['action', 'image', 'created_at'])
                ->make(true);
        }
        
        return view('admin.index.index', compact('title', 'breadcrumbs'));
    }

    public function add(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:45|unique:indices,name',
                    'url' => 'required|max:255|url',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ], [
                    'name.unique' => 'The index name has already been taken.',
                    'name.required' => 'The index name field is required.',
                    'name.max' => 'The index name must not be greater than 45 characters.',
                    'url.url' => 'Please enter a valid URL.',
                    'image.required' => 'The image field is required.',
                    'image.image' => 'The file must be an image.',
                    'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                    'image.max' => 'The image may not be greater than 2MB.'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'false',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $index = new Index();
                $index->name = $request->get('name');
                $index->url = $request->get('url');

                if ($request->hasFile('image')) {
                    $destinationPath = 'public/uploads/indexs/';
                    ensureDirectoryExists(public_path($destinationPath));
                    $destinationPath = uploadImage($request->image, $destinationPath);
                    $index->image = $destinationPath;
                }

                $index->save();

                return response()->json([
                    'status' => 'true', 
                    'message' => "Index added successfully."
                ]);

            } catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json([
                    'status' => 'false', 
                    'message' => 'An error occurred while adding the index.'
                ], 500);
            }
        }

        return response()->json([
            'status' => 'false',
            'message' => 'Invalid request method.'
        ], 405);
    }

    public function editData($id)
    {
        try {
            $index = Index::findOrFail($id);
            return response()->json($index);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'Index not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $index = Index::findOrFail($id);

                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:45|unique:indices,name,' . $id,
                    'url' => 'required|max:255|url',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ], [
                    'name.unique' => 'The index name has already been taken.',
                    'name.required' => 'The index name field is required.',
                    'name.max' => 'The index name must not be greater than 45 characters.',
                    'url.url' => 'Please enter a valid URL.',
                    'image.image' => 'The file must be an image.',
                    'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                    'image.max' => 'The image may not be greater than 2MB.'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'false',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $index->name = $request->get('name');
                $index->url = $request->get('url');

                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if ($index->image && file_exists(public_path($index->image))) {
                        unlink(public_path($index->image));
                    }
                    
                    $destinationPath = 'public/uploads/index/';
                    ensureDirectoryExists(public_path($destinationPath));

                    uploadImage($request->image, $destinationPath);

                    $index->image = uploadImage($request->image, $destinationPath);
                }

                $index->save();

                return response()->json([
                    'status' => 'true', 
                    'message' => "Index updated successfully."
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'false', 
                    'message' => 'An error occurred while updating the index.'
                ], 500);
            }
        }

        return response()->json([
            'status' => 'false',
            'message' => 'Invalid request method.'
        ], 405);
    }

    public function delete($id)
    {
        try {
            $index = Index::findOrFail($id);
            
            // Delete image file if exists
            if ($index->image && file_exists(public_path($index->image))) {
                unlink(public_path($index->image));
            }
            
            $index->delete();
            
            return response()->json([
                'status' => 'true',
                'message' => 'Index deleted successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'Error deleting index: ' . $e->getMessage()
            ], 500);
        }
    }
}