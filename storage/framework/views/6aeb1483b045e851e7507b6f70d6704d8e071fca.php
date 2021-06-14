<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('stok')); ?>">Stok Barang</a></li>
                            <li class="breadcrumb-item active">Stok Trip</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <stock-trip></stock-trip>
                </div>






























































                <!-- /.row -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script>
        $(".link-stock-trip").addClass('active')
    </script>














<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/stok/trip.blade.php ENDPATH**/ ?>