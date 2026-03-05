<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LeadershipController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ResourceCategoryController;
use App\Http\Controllers\PublicResourceController; // Added this line

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/leadership', [LeadershipController::class, 'index'])->name('leadership');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/event/{id}', [EventController::class, 'show'])->name('public.events.show');
Route::get('/verify-ticket', [EventController::class, 'verifyTicket'])->name('public.verify-ticket');
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::get('/membership/{id}', [MembershipController::class, 'show'])->name('membership.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [LegalController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [LegalController::class, 'refund'])->name('refund');
Route::get('/news', [\App\Http\Controllers\PublicPostController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\PublicPostController::class, 'show'])->name('news.show');
Route::get('/gallery', [\App\Http\Controllers\PublicGalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{title}', [\App\Http\Controllers\PublicGalleryController::class, 'show'])->name('gallery.show')->where('title', '.*');

// Strategic Initiatives
Route::get('/initiatives', [\App\Http\Controllers\PublicInitiativeController::class, 'index'])->name('public.initiatives.index');
Route::get('/initiatives/{slug}', [\App\Http\Controllers\PublicInitiativeController::class, 'show'])->name('public.initiatives.show');
Route::get('/initiatives/{slug}/download', [\App\Http\Controllers\PublicInitiativeController::class, 'download'])->name('public.initiatives.download');
Route::get('/initiatives/{slug}/view', [\App\Http\Controllers\PublicInitiativeController::class, 'view'])->name('public.initiatives.view');

// Public Resource Hub
Route::get('/resources', [PublicResourceController::class, 'index'])->name('public.resources.index');
Route::get('/resources/{resource}/view', [PublicResourceController::class, 'show'])->name('public.resources.show');
Route::get('/resources/{resource}/stream', [PublicResourceController::class, 'stream'])->name('public.resources.stream');

// Payment Routes
Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/payment/initiate', [App\Http\Controllers\PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/payment/verify', [App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
Route::post('/payment/webhook', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/inquiry', [\App\Http\Controllers\PaymentController::class, 'inquiry'])->name('payment.inquiry');
Route::post('/payment/inquiry', [\App\Http\Controllers\PaymentController::class, 'handleInquiry'])->name('payment.handle_inquiry');
Route::post('/coupon/apply', [App\Http\Controllers\CouponController::class, 'apply'])->name('coupon.apply');

// Member Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('member.logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('/password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Member Protected Routes
Route::middleware(['auth:member'])->group(function () {
    Route::get('/user/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/transactions', [\App\Http\Controllers\Member\DashboardController::class, 'transactions'])->name('user.transactions');
    Route::get('/user/tickets', [\App\Http\Controllers\Member\DashboardController::class, 'tickets'])->name('user.tickets');
    
    Route::get('/user/settings', [\App\Http\Controllers\Member\DashboardController::class, 'settings'])->name('user.settings');
    Route::post('/user/settings/update', [\App\Http\Controllers\Member\DashboardController::class, 'updateSettings'])->name('user.settings.update');
    Route::get('/user/profile', [\App\Http\Controllers\Member\DashboardController::class, 'profile'])->name('user.profile');
    Route::get('/user/events/find', [\App\Http\Controllers\Member\DashboardController::class, 'findEvents'])->name('user.events.find');

    Route::get('/user/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('user.notifications.index');
    Route::post('/user/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('user.notifications.read');
    Route::get('/user/onboarding', [\App\Http\Controllers\Member\OnboardingController::class, 'show'])->name('user.onboarding');
    Route::post('/user/onboarding/update', [\App\Http\Controllers\Member\OnboardingController::class, 'update'])->name('user.onboarding.update');
    
    Route::post('/user/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('user.notifications.mark-all-read');
    
    // Resource Hub Routes
    Route::get('/user/resources', [\App\Http\Controllers\Member\ResourceController::class, 'index'])->name('user.resources.index');
    Route::get('/user/resources/{resource}/download', [\App\Http\Controllers\Member\ResourceController::class, 'download'])->name('user.resources.download');

    // Asset Downloads (Phase 40)
    Route::get('/user/assets/preview/{type}/{id?}', [\App\Http\Controllers\Member\AssetController::class, 'preview'])->name('user.assets.preview');
    Route::get('/user/assets/certificate', [\App\Http\Controllers\Member\AssetController::class, 'downloadCertificate'])->name('user.assets.certificate');
    Route::get('/user/assets/id-card', [\App\Http\Controllers\Member\AssetController::class, 'downloadIdCard'])->name('user.assets.id_card');
    Route::get('/user/assets/ticket/{id}', [\App\Http\Controllers\Member\AssetController::class, 'downloadTicket'])->name('user.assets.ticket');

    // Referral Hub (Phase 39)
    Route::get('/user/referral', [\App\Http\Controllers\Member\ReferralController::class, 'index'])->name('user.referral.index');
    Route::get('/user/referral/network-data', [\App\Http\Controllers\Member\ReferralController::class, 'networkData'])->name('user.referral.network');

    // Course Learning Hub
    Route::get('/user/courses', [\App\Http\Controllers\Member\CourseController::class, 'index'])->name('user.courses.index');
    Route::get('/user/courses/{course:slug}', [\App\Http\Controllers\Member\CourseController::class, 'show'])->name('user.courses.show');
    Route::get('/user/courses/{course:slug}/watch/{lesson}', [\App\Http\Controllers\Member\CourseController::class, 'watch'])->name('user.courses.watch');
    Route::post('/user/courses/{course:slug}/complete/{lesson}', [\App\Http\Controllers\Member\CourseController::class, 'completeLesson'])->name('user.courses.complete');
    Route::get('/user/courses/{course:slug}/certificate', [\App\Http\Controllers\Member\CourseController::class, 'downloadCertificate'])->name('user.courses.certificate');
    Route::get('/user/courses/{course:slug}/quiz/{quiz}', [\App\Http\Controllers\Member\CourseController::class, 'quiz'])->name('user.courses.quiz');
    Route::post('/user/courses/{course:slug}/quiz/{quiz}/submit', [\App\Http\Controllers\Member\CourseController::class, 'submitQuiz'])->name('user.courses.quiz.submit');
});

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        // --- System Admin Routes ---
        Route::middleware(['admin.permission:manage_system'])->group(function () {
            Route::resource('admin-users', \App\Http\Controllers\Admin\AdminUserController::class)->names([
                'index' => 'admin.admin-users.index',
                'create' => 'admin.admin-users.create',
                'store' => 'admin.admin-users.store',
                'edit' => 'admin.admin-users.edit',
                'update' => 'admin.admin-users.update',
                'destroy' => 'admin.admin-users.destroy',
            ]);
            Route::resource('admin-roles', \App\Http\Controllers\Admin\AdminRoleController::class)->names([
                'index' => 'admin.admin-roles.index',
                'create' => 'admin.admin-roles.create',
                'store' => 'admin.admin-roles.store',
                'edit' => 'admin.admin-roles.edit',
                'update' => 'admin.admin-roles.update',
                'destroy' => 'admin.admin-roles.destroy',
            ]);
        });

        Route::middleware(['admin.permission:manage_members'])->group(function () {
            Route::resource('members', \App\Http\Controllers\Admin\MemberController::class)->names([
                'index' => 'admin.members.index',
                'create' => 'admin.members.create',
                'store' => 'admin.members.store',
                'show' => 'admin.members.show',
                'edit' => 'admin.members.edit',
                'update' => 'admin.members.update',
                'destroy' => 'admin.members.destroy',
            ]);
            Route::post('/members/bulk-destroy', [\App\Http\Controllers\Admin\MemberController::class, 'bulkDestroy'])->name('admin.members.bulk-destroy');
            Route::post('/members/bulk-update-role', [\App\Http\Controllers\Admin\MemberController::class, 'bulkUpdateRole'])->name('admin.members.bulk-update-role');
        });

        Route::middleware(['admin.permission:manage_roles'])->group(function () {
            Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->names([
                'index' => 'admin.roles.index',
                'create' => 'admin.roles.create',
                'store' => 'admin.roles.store',
                'edit' => 'admin.roles.edit',
                'update' => 'admin.roles.update',
                'destroy' => 'admin.roles.destroy',
            ]);
        });
        Route::middleware(['admin.permission:manage_events'])->group(function () {
            Route::resource('events', \App\Http\Controllers\Admin\EventController::class)->names([
                'index' => 'admin.events.index',
                'create' => 'admin.events.create',
                'store' => 'admin.events.store',
                'edit' => 'admin.events.edit',
                'update' => 'admin.events.update',
                'destroy' => 'admin.events.destroy',
            ]);
            Route::get('/events/{event}/sales', [\App\Http\Controllers\Admin\EventController::class, 'sales'])->name('admin.events.sales');
            
            // Event Tickets API
            Route::get('/events/tickets/{id}', [\App\Http\Controllers\Admin\EventTicketController::class, 'show']);
            Route::post('/events/tickets', [\App\Http\Controllers\Admin\EventTicketController::class, 'store']);
            Route::put('/events/tickets/{id}', [\App\Http\Controllers\Admin\EventTicketController::class, 'update']);
            Route::delete('/events/tickets/{id}', [\App\Http\Controllers\Admin\EventTicketController::class, 'destroy']);
        });

        Route::middleware(['admin.permission:manage_bulk_import'])->group(function () {
            Route::get('/bulk-import', [\App\Http\Controllers\Admin\BulkImportController::class, 'index'])->name('admin.bulk-import');
            Route::get('/bulk-import/template', [\App\Http\Controllers\Admin\BulkImportController::class, 'downloadTemplate'])->name('admin.bulk-import.template');
            Route::post('/bulk-import', [\App\Http\Controllers\Admin\BulkImportController::class, 'import'])->name('admin.bulk-import.process');
        });

        // Missing Admin Tabs Routes
        Route::middleware(['admin.permission:manage_plans'])->group(function () {
            Route::resource('plans', \App\Http\Controllers\Admin\MembershipPlanController::class)->names([
                'index' => 'admin.plans.index',
                'create' => 'admin.plans.create',
                'store' => 'admin.plans.store',
                'edit' => 'admin.plans.edit',
                'update' => 'admin.plans.update',
                'destroy' => 'admin.plans.destroy',
            ]);
            Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->names([
                'index' => 'admin.coupons.index',
                'create' => 'admin.coupons.create',
                'store' => 'admin.coupons.store',
                'edit' => 'admin.coupons.edit',
                'update' => 'admin.coupons.update',
                'destroy' => 'admin.coupons.destroy',
            ]);
        });
        
        Route::middleware(['admin.permission:manage_initiatives'])->group(function () {
            Route::resource('initiatives', \App\Http\Controllers\Admin\InitiativeController::class)->names([
                'index' => 'admin.initiatives.index',
                'create' => 'admin.initiatives.create',
                'store' => 'admin.initiatives.store',
                'edit' => 'admin.initiatives.edit',
                'update' => 'admin.initiatives.update',
                'destroy' => 'admin.initiatives.destroy',
            ]);
        });

        Route::middleware(['admin.permission:manage_communication'])->group(function () {
            Route::get('/communication', [\App\Http\Controllers\Admin\CommunicationController::class, 'index'])->name('admin.communication.index');
            Route::post('/communication', [\App\Http\Controllers\Admin\CommunicationController::class, 'store'])->name('admin.communication.store');
        });

        Route::middleware(['admin.permission:manage_posts'])->group(function () {
            Route::resource('posts', \App\Http\Controllers\Admin\PostController::class)->names([
                'index' => 'admin.posts.index',
                'create' => 'admin.posts.create',
                'store' => 'admin.posts.store',
                'edit' => 'admin.posts.edit',
                'update' => 'admin.posts.update',
                'destroy' => 'admin.posts.destroy',
            ]);
        });

        Route::middleware(['admin.permission:manage_chapters'])->group(function () {
            Route::get('/chapters', [\App\Http\Controllers\Admin\ChapterController::class, 'index'])->name('admin.chapters.index');
        });
        
        Route::middleware(['admin.permission:manage_analytics'])->group(function () {
            Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');
            Route::post('/analytics/bulk-delete', [\App\Http\Controllers\Admin\AnalyticsController::class, 'bulkDelete'])->name('admin.analytics.bulk-delete');
        });

        Route::middleware(['admin.permission:manage_settings'])->group(function () {
            Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
            Route::get('/settings/payment', [\App\Http\Controllers\Admin\SettingController::class, 'payment'])->name('admin.settings.payment');
            Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
        });

        // Gallery & Resource Management
        Route::middleware(['admin.permission:manage_resources'])->group(function () {
            Route::resource('resources', \App\Http\Controllers\Admin\ResourceController::class)->names([
                'index' => 'admin.resources.index',
                'create' => 'admin.resources.create',
                'store' => 'admin.resources.store',
                'edit' => 'admin.resources.edit',
                'update' => 'admin.resources.update',
                'destroy' => 'admin.resources.destroy',
            ]);
            Route::resource('resource-categories', ResourceCategoryController::class)->names([
                'index' => 'admin.resource-categories.index',
                'create' => 'admin.resource-categories.create',
                'store' => 'admin.resource-categories.store',
                'edit' => 'admin.resource-categories.edit',
                'update' => 'admin.resource-categories.update',
                'destroy' => 'admin.resource-categories.destroy',
            ]);
        });
        
        // Referral Network (Admin View)
        Route::middleware(['admin.permission:manage_referrals'])->group(function () {
            Route::get('/referrals', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('admin.referrals.index');
            Route::get('/referrals/{member}', [\App\Http\Controllers\Admin\ReferralController::class, 'show'])->name('admin.referrals.show');
        });
        
        Route::middleware(['admin.permission:manage_gallery'])->group(function () {
            Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class)->except(['show'])->names([
                'index' => 'admin.gallery.index',
                'create' => 'admin.gallery.create',
                'store' => 'admin.gallery.store',
                'edit' => 'admin.gallery.edit',
                'update' => 'admin.gallery.update',
                'destroy' => 'admin.gallery.destroy',
            ]);
            Route::get('/gallery/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('admin.gallery.show')->where('id', '.*');
            Route::delete('/gallery/image/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'removeImage'])->name('admin.gallery.remove-image');
        });

        // Course Management System (CMS)
        Route::middleware(['admin.permission:manage_gallery'])->group(function () {
            Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class)->names([
                'index' => 'admin.courses.index',
                'create' => 'admin.courses.create',
                'store' => 'admin.courses.store',
                'edit' => 'admin.courses.edit',
                'update' => 'admin.courses.update',
                'destroy' => 'admin.courses.destroy',
            ]);
            Route::post('/courses/{course}/modules', [\App\Http\Controllers\Admin\ModuleController::class, 'store'])->name('admin.modules.store');
            Route::post('/modules/reorder', [\App\Http\Controllers\Admin\ModuleController::class, 'reorder'])->name('admin.modules.reorder');
            Route::delete('/modules/{module}', [\App\Http\Controllers\Admin\ModuleController::class, 'destroy'])->name('admin.modules.destroy');
            Route::post('/modules/{module}/lessons', [\App\Http\Controllers\Admin\LessonController::class, 'store'])->name('admin.lessons.store');
            Route::post('/lessons/reorder', [\App\Http\Controllers\Admin\LessonController::class, 'reorder'])->name('admin.lessons.reorder');
            Route::put('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'update'])->name('admin.lessons.update');
            Route::delete('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy'])->name('admin.lessons.destroy');

            // Quiz Management
            Route::post('/modules/{module}/quizzes', [\App\Http\Controllers\Admin\QuizController::class, 'store'])->name('admin.quizzes.store');
            Route::put('/quizzes/{quiz}', [\App\Http\Controllers\Admin\QuizController::class, 'update'])->name('admin.quizzes.update');
            Route::delete('/quizzes/{quiz}', [\App\Http\Controllers\Admin\QuizController::class, 'destroy'])->name('admin.quizzes.destroy');
            Route::post('/quizzes/{quiz}/questions', [\App\Http\Controllers\Admin\QuizController::class, 'addQuestion'])->name('admin.quizzes.add-question');
            Route::delete('/questions/{question}', [\App\Http\Controllers\Admin\QuizController::class, 'removeQuestion'])->name('admin.quizzes.remove-question');
        });

        // Form Builder Routes
        Route::middleware(['admin.permission:manage_forms'])->group(function () {
            Route::resource('forms', \App\Http\Controllers\Admin\FormController::class)->names([
                'index' => 'admin.forms.index',
                'create' => 'admin.forms.create',
                'store' => 'admin.forms.store',
                'edit' => 'admin.forms.edit',
                'update' => 'admin.forms.update',
                'destroy' => 'admin.forms.destroy',
            ]);
            Route::get('/submissions/{form?}', [\App\Http\Controllers\Admin\SubmissionController::class, 'index'])->name('admin.submissions.index');
            Route::get('/submissions/export/{formId?}', [\App\Http\Controllers\Admin\SubmissionController::class, 'export'])->name('admin.submissions.export');
            Route::get('/submissions/detail/{submission}', [\App\Http\Controllers\Admin\SubmissionController::class, 'show'])->name('admin.submissions.show');
            Route::delete('/submissions/{submission}', [\App\Http\Controllers\Admin\SubmissionController::class, 'destroy'])->name('admin.submissions.destroy');
        });

        // Email Campaign Manager
        Route::middleware(['admin.permission:manage_email_campaigns'])->group(function () {
            Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class)->names([
                'index'   => 'admin.email-templates.index',
                'create'  => 'admin.email-templates.create',
                'store'   => 'admin.email-templates.store',
                'edit'    => 'admin.email-templates.edit',
                'update'  => 'admin.email-templates.update',
                'destroy' => 'admin.email-templates.destroy',
            ]);
            Route::get('/email-templates/{emailTemplate}/send',     [\App\Http\Controllers\Admin\EmailTemplateController::class, 'send'])->name('admin.email-templates.send');
            Route::post('/email-templates/{emailTemplate}/dispatch', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'sendCampaign'])->name('admin.email-templates.dispatch');
            Route::get('/email-campaigns',                           [\App\Http\Controllers\Admin\EmailTemplateController::class, 'campaigns'])->name('admin.email-campaigns.index');
            Route::get('/email-campaigns/compose',                   [\App\Http\Controllers\Admin\EmailTemplateController::class, 'compose'])->name('admin.email-campaigns.compose');
            Route::post('/email-campaigns/compose',                  [\App\Http\Controllers\Admin\EmailTemplateController::class, 'composeAndSend'])->name('admin.email-campaigns.compose.send');
        });

        // Document Design Templates
        Route::middleware(['admin.permission:manage_design_templates'])->group(function () {
            Route::resource('design-templates', \App\Http\Controllers\Admin\DesignTemplateController::class)->names([
                'index'   => 'admin.design-templates.index',
                'create'  => 'admin.design-templates.create',
                'store'   => 'admin.design-templates.store',
                'edit'    => 'admin.design-templates.edit',
                'update'  => 'admin.design-templates.update',
                'destroy' => 'admin.design-templates.destroy',
            ]);
            Route::get('/design-templates/{designTemplate}/builder', [\App\Http\Controllers\Admin\DesignTemplateController::class, 'builder'])->name('admin.design-templates.builder');
        });
    });
});

// Dynamic Public Forms
Route::get('/f/{slug}', [\App\Http\Controllers\PublicFormController::class, 'show'])->name('public.forms.show');
Route::post('/f/{slug}', [\App\Http\Controllers\PublicFormController::class, 'submit'])->name('public.forms.submit');
