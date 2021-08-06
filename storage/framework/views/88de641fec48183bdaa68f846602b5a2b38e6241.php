<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SJ - <?php echo e($stockRequest['id']); ?></title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .logo{
            width: 50%;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @media  only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table>
        <tr class="top">
            <td colspan="10">
                <table>
                    <tr>
                        <td class="title">
                            <img src="https://beliayam.com/img/logo_navbar.png" alt="Icon Beliayam.com" class="logo"/>
                        </td>

                        <td>
                            No. Pesanan #: <span style="font-weight: bolder;"><?php echo e($stockRequest['id']); ?></span><br />
                            Dibuat: <?php echo e($stockRequest['date']); ?><br />
                            PJ: <?php echo e($stockRequest['pj']); ?>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="top">
            <td colspan="10">
                <table>
                    <tr>
                        <td class="address">
                            PT Beli Ayam Com<br />
                            Jl. Guru Muchtar, RT.01/RW.12 <br/>
                            Kel. Cimahpar, Kec. Bogor Utara, Kota Bogor, Jawa Barat 16155
                        </td>

                        <td>
                            Gudang Asal: <?php echo e($origin); ?> <br/>
                            Gudang Tujuan: <?php echo e($destination); ?>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="top">
            <td colspan="10">
                <table>
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>SKU</th>
                            <th>Nama Barang</th>
                            <th>Harga/KG</th>
                            <th>Jumlah Barang (PCS)</th>
                            <th>Jumlah Karung</th>
                            <th>Jumlah Berat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stockRequestItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="item text-center">
                                <td> <?php echo e($key + 1); ?> </td>
                                <td style="text-align: left;"> <?php echo e($stock->sku); ?> </td>
                                <td class="text-left"> <?php echo e($stock->product_name); ?> </td>
                                <td> <sup>Rp</sup> <?php echo e($stock->price ?? 0); ?></td>
                                <td> <?php echo e($stock->total); ?></td>
                                <td> <?php echo e($stock->sack); ?></td>
                                <td> <?php echo e($stock->weight); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="heading text-center">
                            <td colspan="4">Total</td>
                            <td style="text-align: center;"><?php echo e($stockRequest['total_stock']); ?></td>
                            <td><?php echo e($stockRequest['total_sack']); ?></td>
                            <td><?php echo e($stockRequest['total_weight']); ?> Kg</td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
<?php /**PATH /home/wahyu/Websites/stock/resources/views/pages/stok/control/download_stock_request.blade.php ENDPATH**/ ?>