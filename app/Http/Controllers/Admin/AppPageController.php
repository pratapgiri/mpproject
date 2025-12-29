<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\AppPage;
use App\Models\Pages;
use App\Models\Setting;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class AppPageController extends Controller
{


    public function appPageList()
    {
        $title = "CMS Pages List";
        return view('admin/page/appPageList', compact('title'));
    }

    public function showAppPageList()
    {
        $appPage = Pages::orderBy('created_at', 'desc')->get();

        return DataTables::of($appPage)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-md" role="group" aria-label="button groups sm">';
                $btn .= '<button type="button" class="btn btn-secondary" onclick="getAppPageDetail(' . $row->id . ')">Edit</button>';
                $btn .= '<a href="' . route('show-custom-page', $row->slug) . '" target="_blank" class="btn btn-info">View</button>';
                $btn .= '</div';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function viewAppPageDetail(Request $request)
    {
        $appPage = Pages::where('id', $request->id)->first();

        return response()->json($appPage, 200);
    }

    public function editAppPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_id' => 'required',
            'page_title' => 'required',
            'page_content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $appPage = Pages::whereId($request->page_id)->first();
        if ($appPage) {
            $appPage->title = $request->get('page_title');
            $appPage->description = $request->get('page_content');
            $appPage->save();

            return redirect()->back()->with(['type' => 'success', 'status' => 'CMS page successfully updated']);
        } else {
            return redirect()->back()->with(['type' => 'danger', 'status' => 'CMS page not found']);
        }
    }



    public function welcomePage(Request $request)
    {
        $title = "Welcome Page";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => '']
        ];

        if ($request->ajax()) {

            $data = Setting::select('id', 'field_title', 'value')->whereIn('field_name', ['welcome_text1', 'welcome_text2', 'welcome_text3'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-md" role="group" aria-label="button groups sm">';

                    $btn .= '<button type="button" class="btn btn-secondary edit-content-btn" data-id="' . $row->id . '" data-value="' . $row->value . '">Edit</button>';

                    $btn .= '</div';
                    return $btn;
                })
                ->addColumn('value', function ($row) {
                    $truncatedText = strlen($row->value) > 120 ? trim(substr($row->value, 0, 120)) . '......' : $row->value;
                    return '<td>' . $truncatedText . '</td>';
                })
                ->rawColumns(['action', 'value'])
                ->make(true);
        }

        return view('admin.page.welcome-page', compact('title', 'breadcrumbs'));
    }


    public function welcomePageUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $welcomePage = Setting::whereId($request->page_id)->first();
        if ($welcomePage) {
            $welcomePage->value = $request->get('page_content');
            $welcomePage->save();

            return redirect()->back()->with(['type' => 'success', 'status' => 'Content updated successfully.']);
        } else {
            return redirect()->back()->with(['type' => 'danger', 'status' => 'Content not found']);
        }
    }
}
