<?php

use App\Http\Controllers\Admin\IndexController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AppPageController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Admin\CallForPaperController;
use App\Http\Controllers\Admin\UserReportController;
use App\Http\Controllers\Admin\DeletedUserController;
use App\Http\Controllers\Admin\OrganisationController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Front\CustomPageViewController;
use App\Http\Controllers\Admin\DeletionRequestController;
use App\Http\Controllers\Admin\EditorialController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\YearController;

Route::get('/clear-cache', fn() => Artisan::call('cache:clear') && '<h1>Cache facade value cleared</h1>');
Route::get('/optimize', fn() => Artisan::call('optimize') && '<h1>Re optimized class loader</h1>');
Route::get('/optimize-clear', fn() => Artisan::call('optimize:clear') && '<h1>Re optimized class loader</h1>');
Route::get('/route-cache', fn() => Artisan::call('route:cache') && '<h1>Routes cached</h1>');
Route::get('/route-clear', fn() => Artisan::call('route:clear') && '<h1>Route cache cleared</h1>');
Route::get('/view-clear', fn() => Artisan::call('view:clear') && '<h1>View cache cleared</h1>');
Route::get('/config-cache', fn() => Artisan::call('config:cache') && '<h1>Clear Config cleared</h1>');
Route::get('/article/{id}', [App\Http\Controllers\Admin\ArticleController::class, 'publicView'])->name('article.public');

// Public route for getting issues by year (for manuscript submission form)
Route::get('/get-issues-by-year/{id}', [App\Http\Controllers\Admin\IssueController::class, 'getIssuesByYear'])->name('public.issue.byYear');

// QR Code Routes (✓ keep these below show route)
    Route::get('/article/{id}/qr', [ArticleController::class, 'generateQR'])->name('article.qr');
    Route::get('/article/{id}/qr-download', [ArticleController::class, 'downloadQR'])->name('article.qr.download');
    Route::get('admin/article', [ArticleController::class, 'index'])->name('article.index');
    Route::post('admin/article/add', [ArticleController::class, 'add'])->name('article.store');
    Route::get('admin/article/edit/{id}', [ArticleController::class, 'editData'])->name('article.edit.data');
    Route::post('admin/article/update/{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('admin/article/delete/{id}', [ArticleController::class, 'delete'])->name('article.destroy');
    Route::patch('admin/article/status/{id}', [ArticleController::class, 'updateStatus'])->name('article.status');
    Route::get('admin/article/show/{id}', [ArticleController::class, 'show'])->name('article.show');
    
    
// Route::get('/', fn() => view(view: 'home'));

Route::get('/send-email', function () {
    $data = [
        'title' => 'Welcome to Laravel Mail',
        'message' => 'This is a test email sent using Laravel Mail functionality.',
    ];

    Mail::to('')->send(new TestMail($data));

    return 'Email sent successfully!';
});


// Route::any('login', [AuthController::class, 'login'])->name('login');


Route::any('send-chat-notification', [NotificationController::class, 'sendChatNotification']);

Route::get('page/{slug}', [CustomPageViewController::class, 'showPages'])->name('show-custom-page');

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    // dd('dassda');
    Route::any('login', [AuthController::class, 'login'])->name('admin.login');
    Route::get('forgot-password', [AuthController::class, 'forgotPasswordView'])->name('admin.forgetpassword.view');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgotpassword');
    Route::any('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('admin.resetpassword');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // dd('assa');

    Route::get('home', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::any('profile', [HomeController::class, 'profile'])->name('admin.profile');
    Route::any('change-password', [HomeController::class, 'changePassword'])->name('admin.changepassword');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Settings Route
    Route::any('/edit-app-version', [SettingController::class, 'EditAppVersion'])->name('edit_app_version');
    // Route::any('/settings', [SettingController::class, 'manageSetting'])->name('manage_setting');

    // User Management
    Route::get('/users-list', [UserController::class, 'userList'])->name('admin.users-list');
    Route::any('/users/status', [UserController::class, 'status'])->name('admin.users.status');
    Route::get('/users/view/{id}', [UserController::class, 'viewUser'])->name('users.view');
    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::post('/users/update/{id}', [UserController::class, 'update']);
    Route::get('/users/delete-account/{id}', [UserController::class, 'deleteAccount']);

    //**************** User report management *****************
    Route::get('/report_user', [UserReportController::class, 'index'])->name('report_user');
    Route::get('/report_user/view/{id}', [UserReportController::class, 'view']);
    Route::POST('/report_user/status', [UserReportController::class, 'status'])->name('report_user.status');


    //******************* Category Management ********************
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
    Route::any('add/category', [CategoryController::class, 'add'])->name('category.add');
    Route::any('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');


    //******************* Category Management ********************
    Route::any('email-templates', [EmailTemplateController::class, 'index'])->name('email-templates');
    Route::any('email-templates-edit/{id}', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
    Route::any('email-templates-update/{id}', [EmailTemplateController::class, 'update'])->name('email-templates.update');


    // CMS Pages Management
    Route::get('/cms-page', [AppPageController::class, 'appPageList'])->name('appPage');
    Route::get('/cms-page/list', [AppPageController::class, 'showAppPageList'])->name('appPage.list');
    Route::post('/cms-page/detail', [AppPageController::class, 'viewAppPageDetail'])->name('appPage.detail');
    Route::post('/cms-page/edit', [AppPageController::class, 'editAppPage'])->name('appPage.edit');

    //*************** Broadcast Management *****************
    Route::any('broadcast', [BroadcastController::class, 'index'])->name('broadcast');

    //***************Support Controller ***************************
    Route::get('support-list', [SupportController::class, 'index'])->name('admin.support_list');
    Route::post('delete-message/{id}', [SupportController::class, 'destroy_message'])->name('delete_support_msg');
    Route::post('send-message-response', [SupportController::class, 'add_response'])->name('add_response');

    //**************** Account deletion request management *****************
    Route::get('account-deletion-requests', [DeletionRequestController::class, 'index'])->name('account-deletion-requests');
    Route::get('delete/user-account/{id}', [DeletionRequestController::class, 'deleteUserAccount']);


    //******************* Index Management ********************
    Route::get('/index', [IndexController::class, 'index'])->name('index');
    Route::post('/index/add', [IndexController::class, 'add'])->name('index.add');
    Route::post('/index/edit/{id}', [IndexController::class, 'add'])->name('index.edit');
    Route::get('/index/edit/{id}', [IndexController::class, 'editData'])->name('index.edit.data');
    Route::post('/index/update/{id}', [IndexController::class, 'update'])->name('index.update');
    Route::get('/index/delete/{id}', [IndexController::class, 'delete'])->name('index.delete');



    Route::prefix('logos')->name('logo.')->group(function () {

        // List Page + DataTables AJAX
        Route::get('', [LogoController::class, 'index'])->name('list');

        // Add Logo
        Route::post('/add', [LogoController::class, 'add'])->name('add');

        // Fetch edit data (AJAX)
        Route::get('/edit/{id}', [LogoController::class, 'editData'])->name('edit.data');

        // Update Logo
        Route::post('/update/{id}', [LogoController::class, 'update'])->name('update');

        // Delete Logo
        Route::get('/delete/{id}', [LogoController::class, 'delete'])->name('delete');
    });




    Route::prefix('issue')->name('issue.')->group(function () {

        // List + DataTable
        Route::get('', [IssueController::class, 'index'])->name('index');

        // Add
        Route::post('/add', [IssueController::class, 'add'])->name('add');

        // Edit (fetch data)
        Route::get('/edit/{id}', [IssueController::class, 'editData'])->name('edit.data');

        // Update
        Route::post('/update/{id}', [IssueController::class, 'update'])->name('update');

        // Delete
        Route::get('/delete/{id}', [IssueController::class, 'delete'])->name('delete');

        // Update status (only status)
        Route::post('/status/{id}', [IssueController::class, 'updateStatus'])->name('status');
    });
    Route::get('/get-issues-by-year/{id}', [IssueController::class, 'getIssuesByYear'])->name('admin.issue.byYear');




    // ******************* News Management ********************
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::post('/news/add', [NewsController::class, 'add'])->name('news.add');
    Route::get('/news/edit/{id}', [NewsController::class, 'editData'])->name('news.edit.data');
    Route::post('/news/update/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::get('/news/delete/{id}', [NewsController::class, 'delete'])->name('news.delete');
    Route::post('/news/status/{id}', [NewsController::class, 'updateStatus'])->name('news.status');


    // ******************* Call For Papers Management ********************
    Route::get('/call-for-papers', [CallForPaperController::class, 'index'])->name('admin.call.index');
    Route::post('/call-for-papers/add', [CallForPaperController::class, 'add'])->name('admin.call.add');
    Route::get('/call-for-papers/edit/{id}', [CallForPaperController::class, 'editData'])->name('admin.call.edit.data');
    Route::post('/call-for-papers/update/{id}', [CallForPaperController::class, 'update'])->name('admin.call.update');
    Route::get('/call-for-papers/delete/{id}', [CallForPaperController::class, 'delete'])->name('admin.call.delete');
    Route::post('/call-for-papers/status/{id}', [CallForPaperController::class, 'updateStatus'])->name('admin.call.status');


    // ******************* Year Management ********************
    Route::get('/year', [YearController::class, 'index'])->name('year.index');
    Route::post('/year/add', [YearController::class, 'add'])->name('year.add');
    Route::get('/year/edit/{id}', [YearController::class, 'editData'])->name('year.edit.data');
    Route::post('/year/update/{id}', [YearController::class, 'update'])->name('year.update');
    Route::get('/year/delete/{id}', [YearController::class, 'delete'])->name('year.delete');
    Route::post('/year/status/{id}', [YearController::class, 'updateStatus'])->name('year.status');


    // ******************* Article Management ********************

    // ================== ADMIN ARTICLE ROUTES ===================
    Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
    Route::post('/article/add', [ArticleController::class, 'add'])->name('article.store');
    Route::get('/article/edit/{id}', [ArticleController::class, 'editData'])->name('article.edit.data');
    Route::post('/article/update/{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/article/delete/{id}', [ArticleController::class, 'delete'])->name('article.destroy');
    Route::patch('/article/status/{id}', [ArticleController::class, 'updateStatus'])->name('article.status');
    Route::get('/article/show/{id}', [ArticleController::class, 'show'])->name('article.show');

    






    // Editorial Management
    Route::get('/editorial', [EditorialController::class, 'index'])->name('editorial.index');
    Route::post('/editorial/add', [EditorialController::class, 'add'])->name('editorial.add');
    Route::get('/editorial/edit/{id}', [EditorialController::class, 'editData'])->name('editorial.edit.data');
    Route::post('/editorial/update/{id}', [EditorialController::class, 'update'])->name('editorial.update');
    Route::post('/editorial/delete/{id}', [EditorialController::class, 'delete'])->name('editorial.delete');
    Route::post('/editorial/status/{id}', [EditorialController::class, 'updateStatus'])->name('editorial.status');




    Route::get('/subscribers', [SubscribeController::class, 'index'])->name('subscribe.index');
    Route::post('/subscriber/add', [SubscribeController::class, 'add'])->name('subscribe.add');
    Route::get('/subscriber/delete/{id}', [SubscribeController::class, 'delete'])->name('subscribe.delete');


    //*************** DeletedUserController Management *****************

    Route::any('deleted-users', [DeletedUserController::class, 'index'])->name('deleted_users');
});





require __DIR__ . '/user.php';
