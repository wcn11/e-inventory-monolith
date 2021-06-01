<template>
    <div class="col-lg-12 mt-5">
        <div class="table-responsive">
            <table class="table table-borderless table-hover" id="table-stock">
                <thead>
                <tr>
                    <th>Kode SJ</th>
                    <th>Total Stock</th>
                    <th>Total Berat</th>
                    <th>Gudang Asal</th>
                    <th>Gudang Tujuan</th>
                    <th>Tanggal</th>
                    <th>PJ</th>
                    <th>Lihat</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(stok, index) in data" :key="index">
                        <td> {{ stok.id }} </td>
                        <td> {{ stok.total_stock }} </td>
                        <td> {{ stok.total_weight }} </td>
                        <td> {{ stok.origin }} </td>
                        <td> {{ stok.destination }} </td>
                        <td> {{ stok.updated_at | formatDate }} </td>
                        <td> Wahyu</td>
                        <td>
                            <a :href="`/stock/history/${stok.id}/view`" class="btn btn-secondary"><i class="fas fa-eye"></i> Lihat Rincian</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "TabelStock",
    props: [
        'data'
    ],
    filters:{
        formatDate(date){
            return moment(date).format('DD MMMM yyyy, HH:mm');
        }
    },
}
</script>

<style scoped>

</style>
