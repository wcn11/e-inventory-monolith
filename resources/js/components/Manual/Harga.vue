<template>
    <div class="table-responsive-lg">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Stock</th>
                    <th>Harga</th>
                    <th>Terakhir Update</th>
                </tr>
            </thead>
            <tbody>

            <tr data-widget="expandable-table" aria-expanded="false"  v-for="i in count" :key="i">
                <td>183</td>
                <td>John Doe</td>
                <td>11-7-2014</td>
                <td>
                    <stock-manual :index="i"></stock-manual>
                </td>
                <td>
                    <harga-manual :index="i"></harga-manual>
                </td>
                <td>Approved</td>

            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import $ from 'jquery'
import StockManual from "./StokManual/StockManual";
import HargaManual from "./StokManual/HargaManual";
require('../../plugins/jquery-ui.min')

export default {
    name: "Harga",
    components: {
        HargaManual,
        StockManual
    },
    data(){
        return {
            count: 3,
        }
    },
}
</script>

<style scoped>
</style>
