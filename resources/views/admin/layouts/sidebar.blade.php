@php
$adminData = Auth::guard('admin')->user();
$currentAction = \Route::currentRouteAction();
[$controller, $action] = explode('@', $currentAction);
$controller = class_basename($controller);

function isActive($ctrl, $actions = []) {
global $controller, $action;
return ($controller === $ctrl && in_array($action, $actions)) ? 'active selected' : '';
}
@endphp
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="user-profile">
        <div class="user-image">
            <img
                src="@if ($adminData->profile_picture_url != '') {{ $adminData->profile_picture_url }} @else {{ asset('assets/common/images/default-avatar.png') }} @endif">
        </div>
        <div class="user-name">
            {{ $adminData->name }}
        </div>
        <div class="user-designation">
            {{ $adminData->email }}
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item {{ \Request::is('admin/home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <?php $active = $controller == 'UserController' && in_array($action, ['usersList']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('admin.users-list') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">User Management</span>
            </a>
        </li>


        <li class="nav-item {{ isActive('SubscribeController', ['index']) }}">
            <a class="nav-link" href="{{ route('subscribe.index') }}">
                <i class="mdi mdi-email-multiple-outline menu-icon"></i>
                <span class="menu-title">Subscribers</span>
            </a>
        </li>


        <li class="nav-item {{ isActive('ArticleController', ['index']) }}">
            <a class="nav-link" href="{{ route('article.index') }}">
                <i class="mdi mdi-file-document-outline menu-icon"></i>
                <span class="menu-title">Articles</span>
            </a>
        </li>


        <li class="nav-item {{ isActive('EditorialController', ['index']) }}">
            <a class="nav-link" href="{{ route('editorial.index') }}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Editorial</span>
            </a>
        </li>


        <li class="nav-item {{ isActive('IndexController', ['index']) }}">
            <a class="nav-link" href="{{ route('index') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Index</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('IssueController', ['index']) }}">
            <a class="nav-link" href="{{ route('issue.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Issue</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('NewController', ['index']) }}">
            <a class="nav-link" href="{{ route('news.index') }}">
                <i class="mdi mdi-newspaper menu-icon"></i>
                <span class="menu-title">News</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('YearController', ['index']) }}">
            <a class="nav-link" href="{{ route('year.index') }}">
                <i class="mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Year</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('CallForPaperController', ['index']) }}">
            <a class="nav-link" href="{{ route('admin.call.index') }}">
                <i class="mdi mdi-file-document-edit menu-icon"></i>
                <span class="menu-title">Call For Paper</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('LogoController', ['logoList']) }}">
            <a class="nav-link" href="{{ route('logo.list') }}">
                <i class="mdi mdi-image menu-icon"></i>
                <span class="menu-title">Logo</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('CategoryController', ['index']) }}">
            <a class="nav-link" href="{{ route('categories') }}">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Category</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('EmailTemplateController', ['index']) }}">
            <a class="nav-link" href="{{ route('email-templates') }}">
                <i class="mdi mdi-email menu-icon"></i>
                <span class="menu-title">Email Templates</span>
            </a>
        </li>

        <?php $active = $controller == 'AppPageController' && in_array($action, ['appPageList']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('appPage') }}">
                <i class="mdi mdi-file-multiple menu-icon"></i>
                <span class="menu-title">CMS Pages</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('BroadcastController', ['index']) }}">
            <a class="nav-link" href="{{ route('broadcast') }}">
                <i class="mdi mdi-bullhorn menu-icon"></i>
                <span class="menu-title">Broadcast Notification</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('ReportController', ['report_user']) }}">
            <a class="nav-link" href="{{ route('report_user') }}">
                <i class="mdi mdi-chart-bar menu-icon"></i>
                <span class="menu-title">User Report</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('SupportController', ['admin.support_list']) }}">
            <a class="nav-link" href="{{ route('admin.support_list') }}">
                <i class="mdi mdi-lifebuoy menu-icon"></i>
                <span class="menu-title">Support / Feedback</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('AccountController', ['accountDeletionRequests']) }}">
            <a class="nav-link" href="{{ route('account-deletion-requests') }}">
                <i class="mdi mdi-account-remove menu-icon"></i>
                <span class="menu-title">Delete Request</span>
            </a>
        </li>

        <li class="nav-item {{ isActive('UserController', ['deleted_users']) }}">
            <a class="nav-link" href="{{ route('deleted_users') }}">
                <i class="mdi mdi-account-off menu-icon"></i>
                <span class="menu-title">Deleted Accounts</span>
            </a>
        </li>

        <?php $active = $controller == 'SettingController' && in_array($action, ['editSetting']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('edit_app_version') }}">
                <i class="mdi mdi-cellphone-settings menu-icon"></i>
                <span class="menu-title">App Versions</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->