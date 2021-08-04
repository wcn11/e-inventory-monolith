@extends('layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stok {{ $history->id }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stok.trip.cek') }}"> Riwayat Stok</a></li>
                            <li class="breadcrumb-item active">Lihat Rincian Stok</li>
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
{{--                                <h3 class="card-title"></h3>--}}

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
                                    <div class="col-md-6">
                                        <h5><span class="text-bold">Penanggung Jawab:</span> {{ $history->pj }}</h5>
                                    </div>
                                    <div class="col-md-6 justify-content-end">
                                        <div class="wrapper">
                                            <p class="text-bold">{{ $history->origin }} <i class="fas fa-long-arrow-alt-right"></i> {{ $history->destination }}</p>

                                            {{ $history->date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">

                                    <div class="table-responsive">
                                        <table class="table table-hover table-borderless">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>SKU</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Berat Satuan/Kg</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($history->stock_request_item as $key => $h)
                                                <tr>
                                                    <td> {{ $key + 1  }} </td>
                                                    <td> {{ $h->sku }} </td>
                                                    <td> {{ $h->product_name }} </td>
                                                    <td> {{ $h->total  }}</td>
                                                    <td> {{ $h->weight_per_unit  }} Kg</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr class="text-black text-bold">
                                                <td colspan="3" class="text-center">Total</td>
                                                <td>{{ $history->total_stock }}</td>
                                                <td>{{ $history->total_weight }} Kg</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="wrapper">
                                        <a class="btn btn-info" href="{{ route('stok.riwayat.download', $history->id) }}"> <i class="fas fa-file-download"></i> Download PDF</a>
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
