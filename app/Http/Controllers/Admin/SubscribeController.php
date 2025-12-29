<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscribe::select('id', 'name', 'email');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-danger btn-sm delete_subscriber" data-id="' . $row->id . '">
                        Delete
                    </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = "Subscribers";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        return view('admin.subscribe.index', compact('title'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subscribes,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Subscribe::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscriber added successfully'
        ]);
    }

    public function delete($id)
    {
        try {
            Subscribe::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subscriber deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed'
            ], 500);
        }
    }
}
