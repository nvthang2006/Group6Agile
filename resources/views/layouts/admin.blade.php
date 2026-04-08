<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin - Tour Manager')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('cork/layouts/vertical-light-menu/loader.js') }}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('cork/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    @yield('page_css')
    <!-- END PAGE LEVEL STYLES -->
    
    <style>
        /* Premium Admin Layout Enhancements */
        .sidebar-wrapper {
            box-shadow: 4px 0 20px rgba(0,0,0,0.03) !important;
            border-right: none !important;
            background: #ffffff !important;
        }
        .header-container {
            box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        #sidebar ul.menu-categories li.menu.active > a {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3) !important;
            color: white !important;
            margin: 0 10px;
        }
        #sidebar ul.menu-categories li.menu > a {
            border-radius: 12px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        #sidebar ul.menu-categories li.menu > a:hover {
            background: #f1f5f9 !important;
            transform: translateX(5px);
        }
        #sidebar ul.menu-categories li.menu.active > a svg,
        #sidebar ul.menu-categories li.menu.active > a span {
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .navbar .navbar-item.theme-brand {
            background: transparent !important;
        }
        .nav-logo .theme-text a {
            font-weight: 800 !important;
            background: linear-gradient(135deg, #4361ee 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Global Card & Table Frames Enhancements */
        .widget-content-area {
            background: #ffffff;
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            padding: 24px !important;
            transition: all 0.3s ease;
        }
        .widget-content-area:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
        }
        
        /* Datatable Customization */
        .table > thead > tr > th {
            border-bottom: 2px solid #f1f5f9 !important;
            color: #64748b !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 16px 20px !important;
            background: #f8fafc !important;
        }
        .table > tbody > tr > td {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 16px 20px !important;
            color: #475569;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
            transform: scale(1.001);
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2) !important;
            border-radius: 8px !important;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3) !important;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2) !important;
            color: white !important;
            border-radius: 8px !important;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2) !important;
            border-radius: 8px !important;
        }
        
        /* Pagination & Search Frames */
        .dataTables_filter input {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            padding: 8px 16px !important;
            box-shadow: none !important;
            transition: all 0.3s ease;
        }
        .dataTables_filter input:focus {
            border-color: #4361ee !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1) !important;
        }
        .dataTables_length select {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 8px 30px 8px 16px !important;
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, #4361ee 0%, #3a53c4 100%) !important;
            border-color: transparent !important;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3) !important;
            border-radius: 8px !important;
        }
        .page-link {
            border-radius: 8px !important;
            margin: 0 4px;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
        }
        .page-link:hover {
            background: #f1f5f9 !important;
        }
        .dt--bottom-section {
            margin-top: 20px !important;
        }
    </style>
</head>
<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="https://designreset.com/cork/html/src/assets/img/logo2.svg" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"> Tour Manager </a>
                </li>
            </ul>

            <div class="search-animated toggle-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Tìm kiếm...">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x search-close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </div>
                </form>
                <span class="badge badge-secondary">Ctrl + /</span>
            </div>

            <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">

                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    </a>
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <img alt="avatar" src="{{ asset('cork/src/assets/img/profile-30.png') }}" class="rounded-circle">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> <span>Trang chủ</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Đăng xuất</span>
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
                                <img src="https://designreset.com/cork/html/src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link"> Tour Manager </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    {{-- Dashboard --}}
                    <li class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>QUẢN LÝ</span></div>
                    </li>

                    {{-- Danh mục --}}
                    <li class="menu {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <span>Danh mục</span>
                            </div>
                        </a>
                    </li>

                    {{-- Sản phẩm (Tours) --}}
                    <li class="menu {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                <span>Tours / Sản phẩm</span>
                            </div>
                        </a>
                    </li>

                    {{-- Bài viết --}}
                    <li class="menu {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        <a href="{{ route('posts.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span>Bài viết</span>
                            </div>
                        </a>
                    </li>

                    {{-- Đặt tour --}}
                    <li class="menu {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.bookings.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                <span>Đặt tour</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>HỆ THỐNG</span></div>
                    </li>

                    {{-- Về trang chủ --}}
                    <li class="menu">
                        <a href="{{ route('home') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
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
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                </a>
                            <div class="d-flex breadcrumb-content">
                                <div class="page-header">
                                    <div class="page-title"></div>
                                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
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
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <p class="">Copyright &copy; <span class="dynamic-year">{{ date('Y') }}</span> <a target="_blank" href="{{ route('home') }}">Tour Manager</a>, All rights reserved.</p>
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
