@extends('layouts.main')

@section('title', 'Detail Users')

@section('toolbar')
<div class="app-header-wrapper d-flex align-items-center justify-content-around justify-content-lg-between flex-wrap gap-6 gap-lg-0 mb-6 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">
    <!--begin::Page title-->
    <div class="d-flex flex-column justify-content-center">
        <!--begin::Title-->
        <h1 class="text-gray-900 fw-bold fs-2x mb-2">Detail Users</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ url('/') }}" class="text-muted text-hover-danger">Portal</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">/</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ url('/admin/dashboard_admin') }}" class="text-muted text-hover-danger">Dashboard Admin</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">/</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ url('/admin/manage_users') }}" class="text-muted text-hover-danger">Manage Users</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">/</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Detail Users</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    {{-- <div class="d-none d-md-block h-40px border-start border-gray-200 mx-10"></div> --}}
    <div class="d-flex gap-3 gap-lg-8 flex-wrap">
    </div>
</div>
@stop 

@section('content')
<div class="row g-5">
    <div class="col-md-12">
        @if (session('success'))
        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"/>
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h6 class="mb-1 text-success">{{ session('success') }}</h6>
            </div>
        </div>
        @endif
        @if (count($errors) > 0)
        <div class="aleralert alert-danger d-flex align-items-center p-5 mb-10">
            <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                </svg>
            </span>
            <div class="d-flex flex-column">
                @foreach ($errors->all() as $error)
                    <h6 class="mb-1 text-danger">{{ $error }}</h6>
                @endforeach
            </div>
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <i class="bi bi-x fs-1 text-danger"></i>
            </button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h6 class="mb-1 text-danger">{{ session('error') }}</h6>
            </div>
        </div>
        @endif
        <div class="card card-flush shadow-sm p-5" id="detail_form">
            <form @if (isset($data['id'])) action="{{ url('/admin/detail_users') }}/{{$data['id']}}" @else action="{{ url('/admin/detail_users') }}" @endif enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-header">
                    <h3 class="card-title fw-bolder">@if(isset($data['id'])) Edit User {{$data['u']->name}} @else Add User @endif</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body py-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="name" class="form-label">Nama Users</label>
                                <input type="text" required class="form-control form-control-solid" name="name" @if (isset($data['id'])) value="{{ $data['u']->name }}" @endif>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="nik_tg" class="form-label">NIK TG</label>
                                <input type="text" required class="form-control form-control-solid" name="nik_tg" @if (isset($data['id'])) value="{{ $data['u']->nik_tg }}" @endif>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control form-control-solid" name="password" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="privilege" class="form-label">Privilege</label>
                                <select required class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Privilege" name="privilege">
                                    <option value=""></option>
                                    @foreach($data['privilege'] as $privilege)
                                    <option value="{{$privilege->privilege}}" @if(isset($data['id'])) @if ($data['u']->privilege == $privilege->privilege) selected @endif @endif>{{$privilege->privilege}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" required class="form-control form-control-solid" name="email" @if (isset($data['id'])) value="{{ $data['u']->email }}" @endif>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label for="nomor_hp" class="form-label">Nomor Handphone</label>
                                <input type="text" required class="form-control form-control-solid" name="nomor_hp" @if (isset($data['id'])) value="{{ $data['u']->nomor_hp }}" @endif>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="status_active" type="checkbox" value="1" @if (isset($data['id'])) @if ($data['u']->status_active) checked="checked" @endif @else checked="checked" @endif/>
                                    <span class="form-check-label fw-bold text-muted">
                                        Status Active
                                    </span>
                                </label>
                                <!--end::Switch-->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" name="notifikasi" type="checkbox" value="1" @if (isset($data['id'])) @if ($data['u']->notifikasi) checked="checked" @endif @else checked="checked" @endif/>
                                    <span class="form-check-label fw-bold text-muted">
                                        Notifikasi
                                    </span>
                                </label>
                                <!--end::Switch-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ url('/admin/manage_users')}}" class="btn btn-secondary me-5">Back</a>
                    <input type="submit" class="btn btn-danger" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('styles')
<style>
    .hidden {display:none;}
</style>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
</script>
@stop 
