<div class="app-navbar flex-shrink-0 gap-2 gap-lg-4">
    <!--begin::User menu-->
    <div class="app-navbar-item" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <div class="symbol-label" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg')}}); background-position: center center;"></div>
        </div>
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <div class="symbol-label" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg')}}); background-position: center center;"></div>
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">{{ Session::get('user')->name }} 
                        <span class="badge badge-light-danger fw-bold fs-8 px-2 py-1 ms-2">User</span></div>
                        <a href="#" class="fw-semibold text-muted text-hover-danger fs-7">{{ Session::get('user')->privilege }}</a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ url('/')}}" class="menu-link px-5">Kembali ke Portal</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5 my-1">
                <a href="javascript:;" class="menu-link text-muted px-5">DWH Monitoring v1.0.0</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ url('/logout') }}" class="menu-link px-5">Sign Out</a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
</div>