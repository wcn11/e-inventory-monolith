@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stok') }}">Stok Barang</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stok.opname') }}">Stok Opname</a></li>
                            <li class="breadcrumb-item active">Upload Stock Opname</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-box"></i>Daftar Produk</h1>
                            </div>
                            <div class="card-body">
                                <opname-upload :request="{{ json_encode($request) }}"></opname-upload>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"i></script>
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
        // $(".link-stock").addClass('active')
        jQuery(document).ready(function ($) {
            $('#table-product').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $("#table-product_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-product_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            // $(".remove-product").click(function (){
            //
            //     $('#table-product').DataTable().ajax.reload();
            // })

        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @error('opname_upload_error')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        @error('invalid_file')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        @error('invalid_row')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        @error('sku_not_exist')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        @error('invalid_file')
        Toast.fire({
            icon: 'error',
            title: '{{ $message }}'
        })
        @enderror

        })
    </script>
@endpush
