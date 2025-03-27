@extends('layouts.main')

@section('title', 'Manage Airflow Table')

@section('toolbar')
<div class="app-header-wrapper d-flex align-items-center justify-content-around justify-content-lg-between flex-wrap gap-6 gap-lg-0 mb-6 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">
    <!--begin::Page title-->
    <div class="d-flex flex-column justify-content-center">
        <!--begin::Title-->
        <h1 class="text-gray-900 fw-bold fs-2x mb-2">Manage Airflow Table</h1>
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
            <li class="breadcrumb-item text-muted">Manage Airflow Table</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    {{-- <div class="d-none d-md-block h-40px border-start border-gray-200 mx-10"></div> --}}
    <div class="d-flex gap-3 gap-lg-8 flex-wrap">
    </div>
</div>

<!--begin::Actions-->

<!--end::Actions-->
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
        <div class="card card-flush shadow-sm p-5" id="manage_table">
            @csrf
            <div class="card-header">
                <h3 class="card-title fw-bolder">Manage Airflow Table</h3>
                <div class="card-toolbar">
                    <div class="d-flex align-items-center py-2">
                        <a href="{{ url('/admin/detail_airflow_table')}}" class="btn btn-sm btn-danger">Add Table</a>
                    </div>
                </div>
            </div>
            <div class="card-body py-5">
                <table class="table table-rounded table-striped border gy-5 gs-5" id="datatable">
                    <thead>
                        <tr>
                            <th style="min-width: 30px; font-weight:600;">#</th>
                            <th style="min-width: 80px; font-weight:600;">Table</th>
                            <th style="min-width: 200px; font-weight:600;">Deskripsi</th>
                            <th style="min-width: 80px; font-weight:600;">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="min-width: 30px; font-weight:600;">#</th>
                            <th style="min-width: 80px; font-weight:600;">Table</th>
                            <th style="min-width: 200px; font-weight:600;">Deskripsi</th>
                            <th style="min-width: 80px; font-weight:600;">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- <div class="card-footer text-end">
            </div> -->
        </div>
    </div>
</div>
@stop

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<style>
    .hidden {display:none;}
    tr th {padding: 10px !important;}
    tr td {padding: 1px 1px 1px 5px !important; font-size: 12px !important; vertical-align: middle !important;}
    .table-striped>tbody>tr:nth-of-type(odd)>* { --bs-table-accent-bg: #eeeeee !important;}
</style>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script>
    var DataTable = function () {
    var blockUI = new KTBlockUI(document.querySelector('#manage_table'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    });
    var initTable = function initTable() {
      var table = $('#datatable');

      
  
      var datatable = table.DataTable({
        fixedHeader: {
            header: true,
            headerOffset: 70,
        },
        scrollX: true,
        scrollCollapse: true,
        processing: true,
        serverSide: true,
        // ordering: false,
        // oSearch: {"sSearch": "{{Session::get('searchQry')}}" },
        ajax: {
          url: "{{ url('/')}}/api/admin/get_list_manage_airflow_table",
          data: {
            _token : $("input[name='_token']").val()
          },
          type: 'GET',
        },
        order: [2, 'asc'],
        dom:
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        // columnDefs: [{
        //   targets: [1, -1],
        //   orderable: false,
        //   width: '125px'
        // },{
        //   targets: [0,1,3,4
        //     @for($i = 6; $i <= 109; $i++)
        //     , {{$i}}
        //     @endfor
        //   ],
        //   orderable: false
        // },{
        //   targets: [2,5],
        //   orderable: true
        // }
        // {
        //     className: 'select-checkbox',
        //     targets:   0
        // }
        // ],
        // select: {
        //     style: 'multi',
        //     // selector: 'td:first-child'
        // },
      }).on('click', '.btn-delete',function(){
        var id = $(this).attr('data-id');
        var token = $('input[name="_token"]').val();
        var formData = new FormData();
        formData.append('_token', token);
        if ($(this).hasClass('btn-delete')){
          $.confirm({
              title: 'Konfirmasi Delete Airflow Table',
              content: 'Apakah anda yakin akan menghapus table ini?',
              type: 'red',
              typeAnimated: true,
              buttons: {
                  ya: {
                      text: 'Delete',
                      btnClass: 'btn-red',
                      action: function(){
                          blockUI.block();
                          $.ajax({
                              url: "{{ url('/')}}/api/admin/delete_airflow_table/" + id,
                              type: 'POST',
                              data: formData,
                              processData: false,
                              contentType: false,
                              success: function(response) {
                                  blockUI.release();
                                  location.reload();
                              },error: function(error){
                                  console.log(error)
                              }
                          });
                      }
                  },
                  cancel: function () {
                  }
              }
          });
        }
      });

    //   $('#tahun').on( 'change', function () {
    //   datatable
    //       .columns( 5 )
    //       .search( this.value )
    //       .draw();
    //   });

      datatable.on( 'draw.dt', function () {
      var PageInfo = $('#datatable').DataTable().page.info();
          datatable.column(0, { page: 'current' }).nodes().each( function (cell, i) {
              cell.innerHTML = i + 1 + PageInfo.start;
          } );
          datatable.column(-1, { page: 'current' }).nodes().each( function (cell, i) {
              cell.innerHTML = '<div style="white-space:nowrap">\
                              <a href="{{ url("admin/detail_airflow_table") }}/'+ cell.innerHTML + '" class="btn btn-sm btn-secondary me-2 px-5 py-2 my-1" title="Edit Table">\
                                Edit Table\
                              </a>\
                              <a data-id="' +  cell.innerHTML + '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">\
                                    <span class="svg-icon svg-icon-muted svg-icon-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\
                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>\
                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>\
                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>\
                                    </svg></span>\
                              </a>\
                          </div>';
          });
      });

    };

   
  
    return {
      //main function to initiate the module
      init: function init() {
        initTable();
      }
    };
  }();

    $(document).ready(function () {     
        DataTable.init();     
    })
</script>
@stop 
