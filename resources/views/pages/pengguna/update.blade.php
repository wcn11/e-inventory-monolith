@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-user-tag"></i> Update Peran</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user') }}">Pengguna</a></li>
                            <li class="breadcrumb-item active">Update Pengguna</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                Update Pengguna Baru
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.update', ['id' => $user->id]) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="name" value="{{ $user->name }}" id="name" placeholder="Nama Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control form-control-border" value="{{ $user->email }}" name="email" id="email" placeholder="Email Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password <span class="text-danger">*kosongkan bila tidak ingin ubah password</span></label>
                                                <input type="password" name="password" class="form-control form-control-border" id="password" placeholder="Password Pengguna">
                                            </div>
                                            <div class="form-group">
                                                <label for="password-confirm">Konfirmasi Password <span class="text-danger">*kosongkan bila tidak ingin ubah password</span></label>
                                                <input type="password" name="password-confirm" class="form-control form-control-border" id="password-confirm" placeholder="Konfirmasi Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Wewenang / Otoritas <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="role" id="role" required>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $user->getRoleNames()[0] === $role->name ? "selected" : "" }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="is_enable">Status Pengguna</label> <br>
                                                        <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" @if($user->is_enable === 'on') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="checkbox" id="checkbox_id">
                                                        <label for="checkbox_id" class="ml-2"> Kirim Email Update Pengguna</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group text-right">
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <button class="btn btn-success"><i class="fas fa-user-edit"></i> Update Pengguna</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>

        jQuery(document).ready(function ($) {
            // switch button
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
            // end switch
        })
    </script>
@endpush
