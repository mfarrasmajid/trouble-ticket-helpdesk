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
        </style>
        @yield('styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" class="app-blank">
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
			@yield('content')
			<!--end::Page-->
		</div>
		<!--end::App-->
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