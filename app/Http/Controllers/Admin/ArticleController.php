<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Reference;
use App\Models\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Helpers\QrCodeHelper; // <-- Use our QrCodeHelper
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::with(['year', 'issue', 'category', 'authors'])
                ->select('articles.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('year', fn($row) => $row->year->year ?? '-')
                ->addColumn('issue', fn($row) => $row->issue->issues ?? '-')
                ->addColumn('category', fn($row) => $row->category->name ?? '-')
                ->addColumn('qr', function ($row) {
                    return '<a href="' . route('article.qr', $row->id) . '" target="_blank"><img src="' . route('article.qr', $row->id) . '" width="50"></a>';
                })
                ->editColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" ' . $checked . ' class="status-toggle" data-id="' . $row->id . '">
                                <span class="slider"></span>
                            </label>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item view-article" href="javascript:void(0)" data-id="' . $row->id . '">View</a>
                                <a class="dropdown-item edit-article" href="javascript:void(0)" data-id="' . $row->id . '">Edit</a>
                                <a class="dropdown-item delete_article" href="javascript:void(0)" data-id="' . $row->id . '">Delete</a>
                                <a class="dropdown-item" target="_blank" href="' . route('article.qr.download', $row->id) . '">Download QR</a>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['qr', 'status', 'action'])
                ->make(true);
        }

        $years = Year::where('status', true)->get();
        $categories = Category::where('status', true)->get();

        return view('admin.article.index', compact('years', 'categories'));
    }

    public function getIssuesByYear($yearId)
    {
        $issues = Issue::where('year_id', $yearId)->where('status', true)->get();
        return response()->json($issues);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year_id' => 'required|exists:years,id',
            'issues_id' => 'required|exists:issues,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:500',
            'abstract' => 'required|string',
            'keyword' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string|max:255',
            'article' => 'required|mimes:pdf|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $destinationPath = 'public/uploads/articles/';
            $articleFile = $this->uploadImage($request->file('article'), $destinationPath);

            // Upload image using uploadImage function
            $imageFile = null;
            if ($request->hasFile('image')) {
                $destinationPath = 'public/uploads/articles/';
                $this->ensureDirectoryExists(base_path($destinationPath));
                $imageFile = $this->uploadImage($request->file('image'), $destinationPath);
            }

            // Create article
            $article = Article::create([
                'year_id' => $request->year_id,
                'issues_id' => $request->issues_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'abstract' => $request->abstract,
                'keyword' => $request->keyword,
                'doi' => $request->doi,
                'article' => $articleFile,
                'image' => $imageFile,
                'status' => 1
            ]);

            // Create authors
            foreach ($request->authors as $name) {
                Author::create([
                    'article_id' => $article->id,
                    'author' => $name
                ]);
            }

            // Create references if exists
            if ($request->has('references') && is_array($request->references)) {
                foreach ($request->references as $ref) {
                    if (!empty(trim($ref))) {
                        Reference::create([
                            'article_id' => $article->id,
                            'reference' => $ref
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Article added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editData($id)
    {
        try {
            $article = Article::with(['authors', 'references'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $article
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'year_id' => 'required|exists:years,id',
            'issues_id' => 'required|exists:issues,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:500',
            'abstract' => 'required|string',
            'keyword' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|string|max:255',
            'article' => 'nullable|mimes:pdf|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $article = Article::findOrFail($id);

            // Update article file if new one is uploaded
            if ($request->hasFile('article')) {
                // Delete old file
                if ($article->article && File::exists(public_path("storage/" . $article->article))) {
                    File::delete(public_path("storage/" . $article->article));
                }
                $destinationPath = 'public/uploads/articles/';
                $article->article = $this->uploadImage($request->file('article'), $destinationPath);
            }

            // Update image using uploadImage function if new one is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($article->image && File::exists(public_path($article->image))) {
                    File::delete(public_path($article->image));
                }
                $destinationPath = 'public/uploads/articles/';
                $this->ensureDirectoryExists(base_path($destinationPath));
                $imageFile = $this->uploadImage($request->file('image'), $destinationPath);
                $article->image = $imageFile;
            }

            // Update article data
            $article->update([
                'year_id' => $request->year_id,
                'issues_id' => $request->issues_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'abstract' => $request->abstract,
                'keyword' => $request->keyword,
                'doi' => $request->doi,
                'image' => $article->image, // ensure image is updated if changed
                'article' => $article->article // ensure article file is updated if changed
            ]);

            // Update authors
            Author::where('article_id', $article->id)->delete();
            foreach ($request->authors as $name) {
                Author::create([
                    'article_id' => $article->id,
                    'author' => $name
                ]);
            }

            // Update references
            Reference::where('article_id', $article->id)->delete();
            if ($request->has('references') && is_array($request->references)) {
                foreach ($request->references as $ref) {
                    if (!empty(trim($ref))) {
                        Reference::create([
                            'article_id' => $article->id,
                            'reference' => $ref
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Article updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $article = Article::findOrFail($id);

            // Delete authors and references
            $article->authors()->delete();
            $article->references()->delete();

            // Delete files
            if ($article->article && File::exists(public_path('storage/' . $article->article))) {
                File::delete(public_path('storage/' . $article->article));
            }
            if ($article->image && File::exists(public_path($article->image))) {
                File::delete(public_path($article->image));
            }

            // Delete article
            $article->delete();

            return response()->json([
                'success' => true,
                'message' => 'Article deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->status = $article->status == 1 ? 0 : 1;
            $article->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'status' => $article->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status'
            ], 500);
        }
    }

    /**
     * Upload Image Function
     */
    private function uploadImage($image, $destinationPath)
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $this->ensureDirectoryExists(base_path($destinationPath));
        $image->move(base_path($destinationPath), $imageName);
        return str_replace('public/', '', $destinationPath) . $imageName;
    }

    /**
     * Ensure Directory Exists
     */
    private function ensureDirectoryExists($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
    }

    /**
     * Generate and serve QR code image for an article.
     * Used for article.qr route.
     */
    public function generateQR($id)
    {
        $article = Article::findOrFail($id);
        $url = route('article.show', $article->id);

        // Use the new QrCodeHelper to generate QR code as a PNG string
        try {
            $qr_code_path = QrCodeHelper::generate($url, 'qrcodes', 200);
            $qr_code_content = Storage::disk('public')->get($qr_code_path);
            return response($qr_code_content)->header('Content-Type', 'image/png');
        } catch (\Exception $e) {
            return response('QR code generation error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Download QR code for an article.
     * Used for article.qr.download route.
     */
    public function downloadQR($id)
    {
        $article = Article::findOrFail($id);
        $url = route('article.show', $article->id);
        $fileName = "qr_article_" . $article->id . ".png";

        try {
            $qr_code_path = QrCodeHelper::generate($url, 'qrcodes', 600);
            $qr_code_content = Storage::disk('public')->get($qr_code_path);

            return response($qr_code_content)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            return response('QR code generation error: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        $article = Article::with(['year', 'issue', 'category', 'authors', 'references'])
            ->findOrFail($id);

        // Always return a QR code (not saved to DB, generated on the fly)
        $qr_code_url = route('article.qr', $article->id);

        return response()->json([
            'success' => true,
            'data' => $article,
            'qr_code_url' => $qr_code_url
        ]);
    }


    // ************* Public View *************
    public function publicView($id)
    {
        $article = Article::with(['year', 'issue', 'category', 'authors', 'references'])
            ->findOrFail($id);

        return view('article.view', compact('article'));
    }
}
