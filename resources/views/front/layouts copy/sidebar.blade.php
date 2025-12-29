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
                src="@if ($adminData->profile_picture_url != '') {{ $adminData->profile_picture_url }} @else {{ asset('assets/common/images/default-avatar.png') }} @endif ">
        </div>
        <div class="user-name">
            {{ $adminData->name }}
        </div>
        <div class="user-designation">
            {{ $adminData->email }}
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item  {{ \Request::is('admin/home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="icon-box menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <?php $active = $controller == 'HomeController' && in_array($action, ['profile', 'view']) ? 'active selected' : ''; ?>
        {{-- <li class="nav-item {{ $active }}">
        <a class="nav-link" href="{{ route('admin.profile') }}">
            <i class="icon-file menu-icon"></i>
            <span class="menu-title">Profile</span>
        </a>
        </li> --}}



        <?php $active = $controller == 'UserController' && in_array($action, ['usersList']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('admin.users-list') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User Management</span>
            </a>
        </li>
        <li class="nav-item {{ isActive('IndexController', ['index<ist']) }}">
            <a class="nav-link" href="{{ route('index') }}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">index</span>
            </a>
        </li>


        <li class="nav-item {{ isActive('IndexController', ['index<ist']) }}">
            <a class="nav-link" href="{{ route('logo.list') }}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Logo</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories') }}">
                <i class="icon-align-justify menu-icon"></i>
                <span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('email-templates') }}">
                <i class="icon-mail menu-icon"></i>
                <span class="menu-title">Email Templates</span>
            </a>
        </li>

        <?php $active = $controller == 'SettingController' && in_array($action, ['manageSetting']) ? 'active selected' : ''; ?>

        {{-- <?php $active = $controller == 'HomeController' && in_array($action, ['changePassword']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
        <a class="nav-link" href="{{ route('admin.changepassword') }}">
            <i class="icon-lock menu-icon"></i>
            <span class="menu-title">Change Password</span>
        </a>
        </li> --}}
        <?php $active = $controller == 'AppPageController' && in_array($action, ['appPageList']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('appPage') }}">
                <i class="icon-file menu-icon"></i>
                <span class="menu-title">CMS Pages</span>
            </a>
        </li>


        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}">
        <i class="icon-inbox menu-icon"></i>
        <span class="menu-title">Logout</span>
        </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('broadcast') }}">
                <i class="icon-volume menu-icon"></i>
                <span class="menu-title">Broadcast Notification</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('report_user') }}">
                <i class="icon-flag menu-icon"></i>
                <span class="menu-title">User Report</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.support_list') }}">
                <i class="icon-mail menu-icon"></i>
                <span class="menu-title">Support / Feedback</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('account-deletion-requests') }}">
                <i class="icon-delete menu-icon"></i>
                <span class="menu-title">Delete Request</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('deleted_users') }}">
                <i class="icon-delete menu-icon"></i>
                <span class="menu-title">Deleted Accounts</span>
            </a>
        </li>
        <?php $active = $controller == 'SettingController' && in_array($action, ['editSetting']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
            <a class="nav-link" href="{{ route('edit_app_version') }}">
                <i class="icon-book menu-icon"></i>
                <span class="menu-title">App Versions</span>
            </a>
        </li>
        {{-- <?php $active = $controller == 'SettingController' && in_array($action, ['manageSetting']) ? 'active selected' : ''; ?>
        <li class="nav-item {{ $active }}">
        <a class="nav-link" href="{{ route('manage_setting') }}">
            <i class="icon-cog menu-icon"></i>
            <span class="menu-title">Setting</span>
        </a>
        </li> --}}



    </ul>
</nav>
<!-- partial -->