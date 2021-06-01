<?php $__env->startSection('content'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stok <?php echo e($history->id); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"> Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('stok.trip.cek')); ?>"> Riwayat Stok</a></li>
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
                                        <h5><span class="text-bold">Penanggung Jawab:</span> <?php echo e($history->pj); ?></h5>
                                    </div>
                                    <div class="col-md-6 justify-content-end">
                                        <div class="wrapper">
                                            <p class="text-bold"><?php echo e($history->origin); ?> <i class="fas fa-long-arrow-alt-right"></i> <?php echo e($history->destination); ?></p>

                                            <?php echo e($history->date); ?>

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
                                            <?php $__currentLoopData = $history->stock_request_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td> <?php echo e($key + 1); ?> </td>
                                                    <td> <?php echo e($h->sku); ?> </td>
                                                    <td> <?php echo e($h->product_name); ?> </td>
                                                    <td> <?php echo e($h->total); ?></td>
                                                    <td> <?php echo e($h->weight_per_unit); ?> Kg</td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                            <tfoot>
                                            <tr class="text-black text-bold">
                                                <td colspan="3" class="text-center">Total</td>
                                                <td><?php echo e($history->total_stock); ?></td>
                                                <td><?php echo e($history->total_weight); ?> Kg</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="wrapper">
                                        <a class="btn btn-info" href="<?php echo e(route('stok.riwayat.download', $history->id)); ?>"> <i class="fas fa-file-download"></i> Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/stok/view.blade.php ENDPATH**/ ?>