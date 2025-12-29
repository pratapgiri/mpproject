<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Year;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function submitManuscript()
    {

        $title = "Submit Manuscript";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $categories = Category::where('status', 1)->get();
        $years = Year::where('status', 1)->get();

        return view('frontend.current-issues.submit-manuscript', compact('categories', 'years', 'title', 'breadcrumbs'));
    }
}
