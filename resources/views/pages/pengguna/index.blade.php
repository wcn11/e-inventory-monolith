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
                            <li class="breadcrumb-item active">Pengguna</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                Pengguna System Inventory Beliayam.com
                            </div>
                            <div class="card-body">

                                <!-- /.col -->
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">

                                            <div class="card-tools">
                                                <a href="{{ route('pengguna.create') }}" class="btn btn-success"><i class="fas fa-user-tag"></i> Tambah Pengguna</a>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0 table-responsive">
                                            <user-data :data="{{ $users }}"></user-data>
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
