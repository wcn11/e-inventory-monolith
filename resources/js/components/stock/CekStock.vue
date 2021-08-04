<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-border" placeholder="Kode Stock">
                <div class="input-group-append">
                    <button class="btn btn-warning float-right"> <i class="fad fa-print-search"></i> Cari Stock</button>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-5">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                           <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Karung</th>
                            <th>Total Berat/Karung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Broiler 05-06</td>
                            <td>8</td>
                            <td>13</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CekStock"
}
</script>

<style scoped>

</style>
