<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Index;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('home', compact('title', 'breadcrumbs', 'indexing'));
    }

    public function fromEditor()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('from-edit', compact('title', 'breadcrumbs', 'indexing'));
    }

    public function editorialBoard()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('editorial-board', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function joinReviewer()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('join-reviewer', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function authorInstruction()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('authore', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function reviewProcedure()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('review', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function copyrightForm()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('copy-right', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function publicationEthics()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('public', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function privacyPolicy()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('privacy-policy', compact('title', 'breadcrumbs', 'indexing'));
    }


    


    public function termsCondition()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('home', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function refundPolicy()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('refund-policy', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function currentIssue()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('current-issue', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function trackArticles()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('track-articles', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function archive()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('archive', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function processingFees()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('processing-fees', compact('title', 'breadcrumbs', 'indexing'));
    }


    public function contactUs()
    {
        $title = "Home";
        $breadcrumbs = [
            ['name' => $title, 'relation' => 'Current', 'url' => ''],
        ];

        $indexing = Index::where('status', 1)->get();

        // Fix: Use only positional arguments OR only named arguments in the view() helper
        // Recommended: Use positional, as in view('home', ...)
        return view('contact', compact('title', 'breadcrumbs', 'indexing'));
    }


   
}
