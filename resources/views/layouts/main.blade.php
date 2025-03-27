<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>DWH Monitoring - @yield('title')</title>
		<meta charset="utf-8" />
		<meta name="description" content="DWH Monitoring" />
		<meta name="keywords" content="dwh, datawarehouse, metronic, information, technology" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="DWH Monitoring" />
		<meta property="og:url" content="{{ url('/') }}" />
		<meta property="og:site_name" content="DWH Monitoring" />
		<link rel="canonical" href="{{ url('/') }}" />
		<link rel="shortcut icon" href="{{ asset('assets/_dwh/icon.png') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) 
            if (window.top != window.self) { 
                window.top.location.replace(window.self.location.href); 
            }
        </script>

        <style>
            body {
                font-family: 'Gabarito';
            }
            .menu-state-primary .menu-item .menu-link.active .menu-title,
            .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here), .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here),
            .menu-state-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title, .menu-state-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title {
                color: var(--bs-danger);
            }
            .menu-state-bullet-primary .menu-item .menu-link.active .menu-bullet .bullet,
            .menu-state-bullet-primary .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-bullet .bullet, .menu-state-bullet-primary .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-bullet .bullet,
			.menu-state-bullet-primary .menu-item.show>.menu-link .menu-bullet .bullet,
			.menu-state-bullet-primary .menu-item.here>.menu-link .menu-bullet .bullet{
                background-color: var(--bs-danger);
            }
            .menu-item:hover>.menu-link .menu-arrow:after, .menu-item.hover>.menu-link .menu-arrow:after, 
			.menu-item.here>.menu-link .menu-arrow:after,
			.menu-item.show>.menu-link .menu-arrow:after {
                color: var(--bs-text-danger) !important;
                background-color: var(--bs-text-danger) !important;
            }
			.menu-state-color .menu-item .menu-link.active .menu-title,
			.menu-state-color .menu-item .menu-link.active .menu-icon, .menu-state-color .menu-item .menu-link.active .menu-icon .svg-icon, .menu-state-color .menu-item .menu-link.active .menu-icon i,
			.menu-state-color .menu-item .menu-link.active .menu-icon, .menu-state-color .menu-item .menu-link.active .menu-icon .svg-icon, .menu-state-color .menu-item .menu-link.active .menu-icon i,
			.menu-state-color .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title, .menu-state-color .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title, 
			.menu-state-color .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-icon, .menu-state-color .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-icon .svg-icon, .menu-state-color .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-icon i, .menu-state-color .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon, .menu-state-color .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon .svg-icon, .menu-state-color .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-icon i {
				color: var(--bs-danger);
			}
			.active>.page-link, .page-link.active {
				background-color: var(--bs-danger);
			}
			.page-link:hover {
				background-color: var(--bs-danger);
			}
			.menu-state-primary .menu-item.here>.menu-link .menu-title, .menu-state-primary .menu-item.here>.menu-link {
				color: var(--bs-danger);
			}
        </style>
        @yield('styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; 
            if ( document.documentElement ) { 
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
                } else { 
                    if ( localStorage.getItem("data-bs-theme") !== null ) { 
                        themeMode = localStorage.getItem("data-bs-theme"); 
                    } else { 
                        themeMode = defaultThemeMode; 
                    } 
                } 
                if (themeMode === "system") { 
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
                } 
                document.documentElement.setAttribute("data-bs-theme", themeMode); 
            }
        </script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header d-flex">
					<!--begin::Header container-->
					<div class="app-container container-fluid d-flex align-items-center justify-content-between" id="kt_app_header_container">
						<!--begin::Logo-->
						<div class="app-header-logo d-flex flex-center">
							<!--begin::Logo image-->
							<a href="{{ url('/') }}">
								<img alt="Logo" src="{{ asset('assets/_dwh/icon.png')}}" class="mh-50px" />
							</a>
							<!--end::Logo image-->
							<!--begin::Sidebar toggle-->
							<button class="btn btn-icon btn-sm btn-active-color-danger d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
								<i class="ki-outline ki-abstract-14 fs-1"></i>
							</button>
							<!--end::Sidebar toggle-->
						</div>
						<!--end::Logo-->
						<div class="d-flex flex-lg-grow-1 flex-stack" id="kt_app_header_wrapper">
							@yield('toolbar')
							<!--begin::Navbar-->
							@include('layouts.navbar')
							<!--end::Navbar-->
						</div>
					</div>
					<!--end::Header container-->
				</div>
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Sidebar-->
					@include('layouts.menu')
					<!--end::Sidebar-->
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid p-0">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									@yield('content')
									<!--end::Row-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								<div class="text-gray-900 order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2025&copy;</span>
									<a href="https://www.mitratel.com" target="_blank" class="text-gray-800 text-hover-danger">PT Dayamitra Telekomunikasi Tbk</a>
								</div>
								<!--end::Copyright-->
								<!--begin::Menu-->
								<ul class="menu menu-gray-600 menu-hover-danger fw-semibold order-1">
									<li class="menu-item">
										<a href="https://servicedesk.mitratel.co.id" target="_blank" class="menu-link px-2">Servicedesk Plus</a>
									</li>
								</ul>
								<!--end::Menu-->
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-outline ki-arrow-up"></i>
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
        @yield('scripts')
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>