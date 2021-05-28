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
                            <li class="breadcrumb-item active">Stok Trip</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <stock-trip></stock-trip>
                </div>

                <div class="row">

                    <!-- Timelime example  -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <div class="timeline">
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-green">10 Feb. 2014</span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="far fa-truck-container bg-blue"></i>
                                    <div class="timeline-item w-100">
                                        <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                        <h3 class="timeline-header"><a href="#">Melakukan Pengiriman</a> </h3>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-green">3 Jan. 2014</span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="far fa-truck-container bg-purple"></i>
                                    <div class="timeline-item w-100">
                                        <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-green">3 Jan. 2021</span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-truck-container bg-maroon"></i>

                                    <div class="timeline-item w-100">
                                        <span class="time"><i class="fas fa-clock"></i> 5 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.timeline -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>

@endsection

@push('css')

@endpush

@push('scripts')

@endpush

