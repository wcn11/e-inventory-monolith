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
                            <li class="breadcrumb-item active">Permintaan Stok</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <request-stock :stocks="{{ json_encode($stock) }}" :request="{{ json_encode($request) }}"></request-stock>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
@endsection

@push('css')
    <style>
        .btn-search{
            margin-top: 2rem;
        }
        .quick-menu-upload {
            min-height: 7rem;
        }
        .bar-stock {
            min-height: 10rem;
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
    <script>
        jQuery(document).ready(function ($) {
            // $(".link-stock").addClass('active')

            $('#table-request').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]]
            });

            $("#table-request_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-request_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            $('#table-process').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]]
            });

            $("#table-process_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-process_wrapper row div:last-child ").css({
                "text-align": 'right',
            })
        })
    </script>
@endpush


