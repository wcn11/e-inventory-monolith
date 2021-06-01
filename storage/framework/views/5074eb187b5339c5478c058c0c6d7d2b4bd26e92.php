<?php $__env->startSection('content'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-user-tag"></i> Tambah Peran</h1>
                        
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('pengguna')); ?>">Pengguna</a></li>
                            <li class="breadcrumb-item active">Buat Pengguna Baru</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                Pengguna Baru
                            </div>
                            <div class="card-body">
                                <form action="<?php echo e(route('pengguna.store')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php echo e($errors); ?>

                                                <label for="name">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-border" name="name" id="name" placeholder="Nama Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control form-control-border" name="email" id="email" placeholder="Email Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control form-control-border" id="password" placeholder="Password Pengguna" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password-confirm">Konfirmasi Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation" class="form-control form-control-border" id="password-confirm" placeholder="Konfirmasi Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="posisi">Wewenang / Otoritas <span class="text-danger">*</span></label>
                                                <select class="custom-select form-control-border" name="role" id="position" required>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="is_enable">Status Pengguna</label> <br>
                                                        <input type="checkbox" class="form-control form-control-border" id="is_enable" name="is_enable" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="send_email_invitation" id="checkbox_id">
                                                        <label for="checkbox_id" class="ml-2"> Kirim Email Undangan Pengguna</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group text-right">
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <button class="btn btn-success" type="submit"><i class="fas fa-user-plus"></i> Tambahkan Pengguna</button>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Bootstrap Switch -->
    <script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"></script>
    <script>

        jQuery(document).ready(function ($) {
            // switch button
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
            // end switch
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/pengguna/create.blade.php ENDPATH**/ ?>