@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Data Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-box"></i> Data Barang</h1>
                            </div>
                            <div class="card-body">
                                <data-barang :data="{{ $products }}" csrf="{{ csrf_token() }}"></data-barang>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div id="tambah-barang">
            <a href="{{ route('barang.create') }}"><button class="feedback"><i class="fas fa-plus-circle"></i></button></a>
        </div>
    </div>
@endsection

@push('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .feedback {
            background-color : #31B0D5;
            color: white;
            padding: 15px 20px;
            border-radius: 50%;
            border-color: transparent;
        }

        .feedback:hover{
            transform: scale(1, 1.1);
        }

        #tambah-barang {
            position: fixed;
            bottom: 5%;
            right: 10px;
        }
    </style>
@endpush

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('#data-barang').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $("#data-barang_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })
            $("#data-barang_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            @error('product_not_found')
                Toast.fire({
                    icon: 'success',
                    title: '{{ $message }}'
                })
            @enderror

            @if(Session::has('product_deleted_success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('product_deleted_success') }}'
            })
            @endif

            @if(Session::has('product_not_found'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('product_not_found') }}'
            })
            @endif

            @if(Session::has('product_updated_status'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('product_updated_status') }}'
                })

            @endif
        })
    </script>
@endpush
