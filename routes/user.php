<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController as FrontendController;
use App\Http\Controllers\User\MainController;

// Home
Route::get('user/', [FrontendController::class, 'home'])->name('home');

// About Pages
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/aims-scope', [FrontendController::class, 'aimScope'])->name('aims-scope');

// Editorial Board
Route::get('/editorial-board', [FrontendController::class, 'editorialBoard'])->name('editorial-board');

// Articles
Route::get('/current-issue', [FrontendController::class, 'currentIssue'])->name('current-issue');
Route::get('/archive', [FrontendController::class, 'archive'])->name('archive');

// For Authors
Route::get('/authors-guideline', [FrontendController::class, 'authorsGuide'])->name('authors-guideline');
Route::get('/copyright-form', [FrontendController::class, 'copyright'])->name('copyright-form');
Route::get('/pay-online', [FrontendController::class, 'payOnline'])->name('pay-online');

// Submission
Route::get('/online-submission', [FrontendController::class, 'submission'])->name('online-submission');

// Policies
Route::get('/editorial-guidelines', [FrontendController::class, 'editorialGuidelines'])->name('editorial-guidelines');
Route::get('/peer-review-policy', [FrontendController::class, 'peerReview'])->name('peer-review-policy');
Route::get('/publication-ethics', [FrontendController::class, 'publicationEthics'])->name('publication-ethics');
Route::get('/plagiarism-policy', [FrontendController::class, 'plagiarism'])->name('plagiarism-policy');
Route::get('/open-access-policy', [FrontendController::class, 'openAccess'])->name('open-access-policy');
Route::get('/conflict-interest-policy', [FrontendController::class, 'conflictInterest'])->name('conflict-interest-policy');
Route::get('/archiving-policy', [FrontendController::class, 'archiving'])->name('archiving-policy');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy-policy');
Route::get('/refund-policy', [FrontendController::class, 'refund'])->name('refund-policy');
Route::get('/withdrawal-policy', [FrontendController::class, 'withdrawal'])->name('withdrawal-policy');
Route::get('/disclaimer-policy', [FrontendController::class, 'disclaimer'])->name('disclaimer-policy');

// Indexing & Abstracting
Route::get('/indexing-abstracting', [FrontendController::class, 'indexing'])->name('indexing-abstracting');

// Contact
Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact');



// ******************** User Routes ********************



Route::controller(MainController::class)->group(function () {

    Route::get('/', 'home')->name('home');
    //About US 
    Route::get('/from-editor-desk', 'fromEditor')->name('from_editor');
    Route::get('/editorial-board', 'editorialBoard')->name('editorial_board');
    Route::get('/join-reviewer', 'joinReviewer')->name('join_reviewer');
    //About Us
    //Instruction
    Route::get('/author-instruction', 'authorInstruction')->name('author_instruction');
    Route::get('/review-procedure', 'reviewProcedure')->name('review_procedure');
    Route::get('/copyright-form', 'copyrightForm')->name('copyright_form');
    Route::get('/publication-ethics', 'publicationEthics')->name('publication_ethics');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy_policy');
    Route::get('/terms-condition', 'termsCondition')->name('terms_condition');
    Route::get('/refund-policy', 'refundPolicy')->name('refund_policy');

    //Instruction

    //Current Issue
    Route::get('/current-issue', 'currentIssue')->name('current_issue');

    //Current Issue

    //Track Your
    Route::get('/track-articles', 'trackArticles')->name('track_articles');

    //Track Your
    //archive
    Route::get('/archive', 'archive')->name('archive');
    //archive

    //processing_fees
    Route::get('/processing-fees', 'processingFees')->name('processing_fees');

    //processing_fees

    //contact_us
    Route::get('/contact-us', 'contactUs')->name('contact_us');

    //contact_us



    


});
Route::get('/submit-manuscript', [FrontendController::class, 'submitManuscript'])->name('submit-manuscript');

