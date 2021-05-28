@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-drumstick-bite"></i> Peran Pengguna</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Peran Pengguna</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                Peran Pengguna System Inventory Beliayam.com
                            </div>
                            <div class="card-body">

                                <!-- /.col -->
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Simple Full Width Table</h3>

                                            <div class="card-tools">
                                                <a href="{{ route('peran.create') }}" class="btn btn-success"><i class="fas fa-user-tag"></i> Tambah Peran</a>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 10px">ID</th>
                                                        <th>Nama</th>
                                                        <th>Jenis Izin</th>
                                                        <th style="width: 40px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>1.</td>
                                                    <td>Update software</td>
                                                    <td><span class="badge bg-danger">55%</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                                                        <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2.</td>
                                                    <td>2.</td>
                                                    <td>Clean database</td>
                                                    <td><span class="badge bg-warning">70%</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                                                        <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3.</td>
                                                    <td>3.</td>
                                                    <td>Cron job running</td>
                                                    <td><span class="badge bg-primary">30%</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                                                        <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4.</td>
                                                    <td>4.</td>
                                                    <td>Fix and squish bugs</td>
                                                    <td><span class="badge bg-success">90%</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                                                        <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
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

@push('css')
    <style>
    </style>
@endpush

@push('scripts')
    </script>
@endpush
