<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin - Tour Manager')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('cork/layouts/vertical-light-menu/loader.js') }}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('cork/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    @yield('page_css')
    <!-- END PAGE LEVEL STYLES -->

    <style>
        /* Premium Admin Layout Enhancements */
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f4f6f8;
            color: #334155;
            letter-spacing: -0.2px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif !important;
            letter-spacing: -0.5px;
        }

        .sidebar-wrapper {
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04) !important;
            border-right: none !important;
            background: #ffffff !important;
        }

        .header-container {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        #sidebar ul.menu-categories li.menu.active>a {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.35) !important;
            color: white !important;
            margin: 0 12px;
        }

        #sidebar ul.menu-categories li.menu>a {
            border-radius: 12px;
            margin: 0 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        #sidebar ul.menu-categories li.menu>a:hover {
            background: #f1f5f9 !important;
            transform: translateX(5px);
        }

        #sidebar ul.menu-categories li.menu.active>a svg,
        #sidebar ul.menu-categories li.menu.active>a span {
            color: white !important;
        }

        .navbar .navbar-item .nav-item.dropdown.user-profile-dropdown .nav-link.user {
            background: #f8fafc;
            border-radius: 30px;
            padding: 5px 15px 5px 5px !important;
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .navbar .navbar-item .nav-item.dropdown.user-profile-dropdown .nav-link.user:hover {
            background: #f1f5f9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .navbar .navbar-item.theme-brand {
            background: transparent !important;
        }

        .nav-logo .theme-text a {
            font-weight: 800 !important;
            background: linear-gradient(135deg, #4361ee 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 22px;
            letter-spacing: -1px;
        }

        /* Global Card & Table Frames Enhancements */
        .widget-content-area {
            background: #ffffff;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid rgba(226, 232, 240, 0.6) !important;
            padding: 24px !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .widget-content-area:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06) !important;
            transform: translateY(-2px);
        }

        /* Datatable Customization */
        .table>thead>tr>th {
            border-bottom: 2px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 13px !important;
            letter-spacing: 0.5px;
            padding: 16px 20px !important;
            background: #f8fafc !important;
        }

        .table>tbody>tr>td {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 16px 20px !important;
            color: #334155;
            vertical-align: middle;
            font-weight: 500;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
            transform: scale(1.005);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            border-radius: 8px;
            z-index: 10;
            position: relative;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25) !important;
            border-radius: 10px !important;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(67, 97, 238, 0.35) !important;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25) !important;
            color: white !important;
            border-radius: 10px !important;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25) !important;
            border-radius: 10px !important;
            font-weight: 600;
        }

        .btn-outline-danger {
            border: 2px solid #ef4444 !important;
            color: #ef4444 !important;
            border-radius: 10px !important;
            background: transparent !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: #ef4444 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25) !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;
            border-radius: 10px !important;
            font-weight: 600;
        }

        /* Pagination & Search Frames */
        .dataTables_filter input {
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            padding: 10px 20px !important;
            box-shadow: none !important;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        .dataTables_filter input:focus {
            border-color: #4361ee !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15) !important;
        }

        .dataTables_length select {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 8px 30px 8px 16px !important;
            font-weight: 600;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border-color: transparent !important;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3) !important;
            border-radius: 10px !important;
            font-weight: 600;
        }

        .page-link {
            border-radius: 10px !important;
            margin: 0 4px;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 500;
        }

        .page-link:hover {
            background: #f1f5f9 !important;
            color: #4361ee !important;
        }

        .dt--bottom-section {
            margin-top: 24px !important;
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 12px 18px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: #334155;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4361ee;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            font-size: 14px;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 8px;
            letter-spacing: 0.3px;
        }

        /* Admin Logo Icon */
        .admin-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
            margin: auto;
        }

        .admin-logo-icon svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="admin-logo-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"> Tour Manager </a>
                </li>
            </ul>

            <div class="search-animated toggle-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto"
                            placeholder="Tìm kiếm...">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x search-close">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </form>
            </div>

            <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">

                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-moon dark-mode">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-sun light-mode">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                    </a>
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <img alt="avatar"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=4361ee&color=fff"
                                    class="rounded-circle">
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5>{{ Auth::user()->name ?? 'Admin' }}</h5>
                                    <p>Quản trị viên</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> <span>Trang chủ</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg> <span>Đăng xuất</span>
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{ route('admin.dashboard') }}">
                                <div class="admin-logo-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link"> Tour Manager </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    {{-- Dashboard --}}
                    <li class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>QUẢN LÝ</span></div>
                    </li>

                    {{-- Danh muc --}}
                    <li class="menu {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                                <span>Danh mục</span>
                            </div>
                        </a>
                    </li>

                    {{-- San pham (Tours) --}}
                    <li class="menu {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-map">
                                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                    <line x1="8" y1="2" x2="8" y2="18"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                                <span>Tours / Sản phẩm</span>
                            </div>
                        </a>
                    </li>

                    {{-- Bai viet --}}
                    <li class="menu {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.posts.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Bài viết</span>
                            </div>
                        </a>
                    </li>

                    {{-- Tai khoan --}}
                    <li class="menu {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span>Tài khoản</span>
                            </div>
                        </a>
                    </li>
                    {{-- Dat tour --}}
                    <li class="menu {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.bookings.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-shopping-cart">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <span>Đặt tour</span>
                            </div>
                        </a>
                    </li>

                    {{-- Tai khoan Ngan hang --}}
                    <li class="menu {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.bank-accounts.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                <span>TK Ngan hang</span>
                            </div>
                        </a>
                    </li>

                    {{-- Voucher giam gia --}}
                    <li class="menu {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.vouchers.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                <span>Mã giảm giá</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg><span>HỆ THỐNG</span></div>
                    </li>

                    {{-- Ve trang chu --}}
                    <li class="menu">
                        <a href="{{ route('home') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-arrow-left">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                <span>Về trang chủ</span>
                            </div>
                        </a>
                    </li>
                </ul>

            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BEGIN BREADCRUMBS  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="@yield('page_heading', 'Admin')">
                            <header class="header navbar navbar-expand-sm">
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse"
                                    data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                    </svg>
                                </a>
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">
                                        <div class="page-title"></div>
                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                @unless (View::hasSection('hide_default_breadcrumb'))
                                                    <li class="breadcrumb-item"><a
                                                            href="{{ route('admin.dashboard') }}">Hệ thống</a></li>
                                                @endunless
                                                @yield('breadcrumb')
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </header>
                        </div>
                    </div>
                    <!--  END BREADCRUMBS  -->

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Main Content --}}
                    <div class="row layout-top-spacing">
                        @yield('content')
                    </div>

                </div>

            </div>

            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright &copy; <span class="dynamic-year">{{ date('Y') }}</span> <a
                            target="_blank" href="{{ route('home') }}">Tour Manager</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Hệ thống quản lý Tour du lịch</p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('cork/src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('cork/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cork/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cork/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('cork/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('cork/layouts/vertical-light-menu/app.js') }}"></script>
    <script src="{{ asset('cork/src/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    @yield('page_js')
    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
