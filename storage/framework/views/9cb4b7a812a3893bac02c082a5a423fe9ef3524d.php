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
                            <li class="breadcrumb-item active">Stok Opname</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <div class="row">
                                    <h1 class="m-0 p-4"><i class="fas fa-box"></i> Stock Opname</h1>
                                </div>
                            </div>
                            <div class="text-right p-2 m-0">

                            </div>
                            <div class="card-body">
                                <opname :stocks="<?php echo e($stocks['stock']); ?>" :recently="<?php echo e($recently); ?>" :limits="<?php echo e(is_array($stocks['limits']) ? json_encode($stocks['limits']) : $stocks['limits']); ?>"></opname>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <script>
        jQuery(document).ready(function ($) {
            $('#table-recenntly-added-stock').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $("#table-recenntly-added-stock_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-recenntly-added-stock_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            $('#table-stock').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $("#table-stock_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-stock_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            $('#table-limits').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $("#table-limits_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#table-limits_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            <?php if(Session::has('stock_uploaded')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo e(Session::get('stock_uploaded')); ?>'
            })
            <?php endif; ?>

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/stok/opname/index.blade.php ENDPATH**/ ?>