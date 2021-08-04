@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard Stock Management Beliayam.com</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- BAR CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Stock Jalan</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12 mt-5">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-hover" id="table-cek">
                                                <thead>
                                                <tr>
                                                    <th>Kode SJ</th>
                                                    <th>Total Stock</th>
                                                    <th>Total Berat</th>
                                                    <th>Gudang Asal</th>
                                                    <th>Gudang Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>PJ</th>
                                                    <th>Lihat</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $h)
                                                    <tr>
                                                        <td> {{ $h->id }} </td>
                                                        <td> {{ $h->total_stock }} </td>
                                                        <td> {{ $h->total_weight }} </td>
                                                        <td> {{ $h->origin }} </td>
                                                        <td> {{ $h->destination }} </td>
                                                        <td> {{ $h->date }} </td>
                                                        <td> {{ $h->pj }}</td>
                                                        <td>
                                                            <a href="{{ route('stok.riwayat.lihat', $h->id) }}" class="btn btn-secondary"><i class="fas fa-eye"></i> Lihat Rincian</a>
                                                            <a class="btn btn-info" href="{{ route('stok.riwayat.download', $h->id) }}"> <i class="fas fa-file-download"></i> Download PDF</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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

            $(".link-stock-history").addClass('active')
            $('#table-cek').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $("#table-cek_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })
            $("#table-cek_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

        })
    </script>
@endpush
