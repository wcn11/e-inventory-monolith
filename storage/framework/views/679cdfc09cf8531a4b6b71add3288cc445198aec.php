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
                            <li class="breadcrumb-item active">Stok Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">

                    <chart-stock :data="<?php echo e($stocks); ?>"></chart-stock>
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        .btn-search{
            margin-top: 2rem;
        }
        .quick-menu-upload {
            min-height: 7rem;
        }
        .bar-stock {
            min-height: 10rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/jszip/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/pdfmake/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/pdfmake/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables-buttons/js/buttons.colVis.min.js')); ?>"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".link-stock").addClass('active')

            const t = $('#data-chart-stock').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[ 1, 'asc' ]]
            });

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            $("#data-chart-stock_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })

            $("#data-chart-stock_wrapper row div:last-child ").css({
                "text-align": 'right',
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/stok/index.blade.php ENDPATH**/ ?>