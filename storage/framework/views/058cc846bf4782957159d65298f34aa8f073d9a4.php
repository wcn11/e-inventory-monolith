<?php $__env->startSection('content'); ?>

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
                            <li class="breadcrumb-item active">kategori Barang</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h1 class="m-0 p-4"><i class="fas fa-th-large"></i> Kategori Barang</h1>
                            </div>

                            <div class="card-body">
                                <data-kategori :data="<?php echo e($categories); ?>" csrf="<?php echo e(csrf_token()); ?>"></data-kategori>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div id="tambah-kategori">
            <a href="<?php echo e(route('kategori.create')); ?>"><button class="feedback"><i class="fas fa-plus-circle"></i></button></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')); ?>">
    <style>
        .feedback {
            background-color : #31B0D5;
            color: white;
            padding: 15px 20px;
            border-radius: 50%;
            border-color: transparent;
        }

        .feedback:hover{
            transform: scale(1, 1.1);
        }

        #tambah-kategori {
            position: fixed;
            bottom: 5%;
            right: 10px;
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
    <!-- SweetAlert2 -->
    <script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('#data-kategori').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $("#data-kategori_filter label").css({
                "text-align": 'left',
                "width" : "100%",
            })
            $("#data-kategori_wrapper row div:last-child ").css({
                "text-align": 'right',
            })

            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            <?php if(Session::has('category_deleted_status')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo e(Session::get('category_deleted_status')); ?>'
            })
            <?php endif; ?>

            <?php if(Session::has('category_cant_delete')): ?>
            Toast.fire({
                icon: 'warning',
                title: '<?php echo e(Session::get('category_cant_delete')); ?>'
            })
            <?php endif; ?>

            <?php if(Session::has('category_updated_status')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo e(Session::get('category_updated_status')); ?>'
            })
            <?php endif; ?>

        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/kategori/index.blade.php ENDPATH**/ ?>