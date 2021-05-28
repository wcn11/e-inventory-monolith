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
                            <li class="breadcrumb-item active">Stok Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-gradient-success bar-stock">
                            <span class="info-box-icon"><i class="fas fa-sort-amount-up-alt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Stock terkini</span>
                                <span class="info-box-number">2450</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                                <span class="progress-description">
                                      Naik 24%
                                    </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-4">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cloud-upload-alt"></i> Upload Data</h3>
                            </div>
                            <div class="card-body quick-menu-upload">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#modal-lg">
                                            <i class="fas fa-upload"></i> Mulai Upload
                                        </button>
                                    </div>
                                    <div class="col col-md-4">
                                        <button type="button" class="btn btn-success m-1" data-toggle="tooltip" data-placement="top" title="Upload Stock"><i class="fas fa-plus"></i> Upload Stock</button>
                                    </div>
                                    <div class="col col-md-4">
                                        <button class="btn btn-success mt-1"  data-toggle="tooltip" data-placement="top" title="Refresh / Sinkronasi"><i class="fas fa-sync-alt rounded-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cloud-upload-alt"></i> Cari Berdasarkan Tanggal:</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <label for="from">Dari Tanggal:</label>
                                        <input type="date" name="from" id="from" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="to">Sampai Tanggal:</label>
                                        <input type="date" name="to" id="to" class="form-control">
                                    </div>
                                    <div class="col">
                                        <div class="offset-md-2 justify-content-center">
                                            <button class="btn btn-success mx-auto btn-search" id="search"   data-toggle="tooltip" data-placement="top" title="Cari Data Berdasarkan Tanggal"><i class="fab fa-searchengin "></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->

                <chart-stock></chart-stock>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Mulai Upload Untuk Update Data Stock</p>
                        <upload-stock></upload-stock>
                    </div>
{{--                    <div class="modal-footer justify-content-center">--}}
{{--                        <button type="button" class="btn btn-dark text-center" data-dismiss="modal"><i class="fas fa-times-circle"></i> Batalkan</button>--}}
{{--                    </div>--}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- /.modal -->
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
            const t = $('#data-chart-stock').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]]
            });

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            $("#data-chart-stock_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#data-chart-stock_wrapper row div:last-child ").css({
                "text-align": 'right',
            })
        })
    </script>
@endpush
