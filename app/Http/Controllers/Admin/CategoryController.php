<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Media;
use App\Lib\Uploader;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function add(Request $request)
    {
        $title = "Category";
        $breadcrumbs = [
            ['name' => 'Category', 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax() && $request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'cat_name'              => 'required|max:45|unique:categories,name',
                    // 'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ], [
                    'cat_name.unique' => 'The category name has already been taken.',
                    'cat_name.required' => 'The category name field is required.',
                    'cat_name.max' => 'The category name must not be greater than 45 characters.'
                ]);
                if ($validator->fails()) {
                    foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                        if (!isset($firstError))
                            $firstError = $messages[0];
                        $error[$field_name] = $messages[0];
                    }

                    return response()->json(array('errors' => $validator->messages()), 422);
                } else {
                    $category = new Category();
                    $category->name = $request->get('cat_name');
                    $category->slug = $request->get('cat_name');

                    // dd($request->image);
                    //upload category image
                    if ($request->hasfile('image')) {
                        $destinationPath = 'public/uploads/category/';
                        ensureDirectoryExists(base_path($destinationPath));
                        $category->image =  uploadImage($request->image, $destinationPath);
                    }

                    $category->save();


                    return ['status' => 'true', 'message' => __("Category added successfully.")];
                }
            } catch (\Exception $e) {
                return ['status' => 'false', 'message' => $e->getMessage()];
            }
        }
        return view('admin.category.add', compact('title', 'breadcrumbs'));
    }


    public function index(Request $request)
    {

        $title = "Category List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {

            $data = Category::orderBy('created_at', 'desc')->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {

                    $btn = '<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="' .  route('category.edit', $row->id) . '">Edit</a>
                        <a class="dropdown-item delete_category" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                        </div>
                    </div>';

                    return $btn;
                })
                ->editColumn('image', function ($row) {
                    return "<img class='sm-img' alt='Category image' src='" . $row->category_image_url . "'>";
                })

                ->editColumn('created_at', function ($row) {
                    return '<td>' . $row->created_at->format('m/d/Y') . '</td>';
                })
                ->rawColumns(['action', 'image', 'created_at'])
                ->make(true);
        }
        return view('admin/category/index', compact('title', 'breadcrumbs'));
    }

    public function edit($id)
    {
        // dd($id);
        $title = "Category List";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        $category = Category::where('id', $id)->first();
        return view('admin/category/edit', compact('title', 'breadcrumbs', 'category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:45|unique:categories,name,' . $id . ',id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ], [
                'name.unique' => 'The category name has already been taken.',
                'name.required' => 'The category name field is required.',
                'name.max' => 'The category name must not be greater than 45 characters.'
            ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                    if (!isset($firstError))
                        $firstError = $messages[0];
                    $error[$field_name] = $messages[0];
                }
                return response()->json(array('errors' => $validator->messages()), 422);
            } else {
                $category = Category::find($id);
                $category->name = $request->get('name');
                $category->slug = $request->get('name');
                if ($request->hasfile('image')) {
                    $destinationPath = 'public/uploads/category/';
                    ensureDirectoryExists(base_path($destinationPath));
                    $category->image =  uploadImage($request->image, $destinationPath);
                }
                $category->save();


                return ['status' => 'true', 'message' => __("Category updated successfully.")];
            }
        } catch (\Exception $e) {
            return ['status' => 'false', 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {

            // $userCategoryCount = Media::where('reference_id', $id)->count();


            // if ($userCategoryCount > 0) {
            //     return redirect()->back()->with("error_msg", "Category can't be deleted because it's already used.");
            // } else {

            $affected = $category->delete();
            if ($affected) {

                // unlink existing file
                if (file_exists($category->category_image_url)) {
                    unlink($category->category_image_url);
                }

                return redirect('/admin/categories')->with('success_msg', 'Category ' . $category->name . ' has been deleted!');
            } else {
                return redirect()->back()->with('error_msg', 'Something went wrong, Please try again!');
            }
            // }
        } else {
            return redirect()->back()->with('error_msg', 'Something went wrong, Please try again!');
        }
    }
}
