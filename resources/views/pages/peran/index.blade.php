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
                                            <h3 class="card-title">Daftar Peran</h3>

                                            <div class="card-tools">
                                                <a href="{{ route('roles.create') }}" class="btn btn-success"><i class="fas fa-user-tag"></i> Tambah Peran</a>
                                            </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">ID</th>
                                                        <th>Nama Peran</th>
                                                        <th style="width: 40px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($roles as $role)
                                                    <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        <delete-confirmation id="{{ $role->id }}" route="{{ route('roles.delete', $role->id) }}"></delete-confirmation>

                                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                                                    </td>
                                                    </tr>
                                                @endforeach
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
