<template>
    <div class="row">

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-hand-holding-box"></i> Riwayat Permintaan Persediaan</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-border table-hover" id="table-request">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>PJ</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Total Permintaan (PCS)</th>
                                <th>Total Permintaan (KG)</th>
                                <th>Total Permintaan (Karung)</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Rincian</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(request, index) in requests" :key="index">
                                <td> {{ request['id'] }}</td>
                                <td> {{ request['pj'] }} </td>
                                <td> {{ request['origin'] }} </td>
                                <td> {{ request['destination'] }} </td>
                                <td> {{ request['total_stock'] }}</td>
                                <td> {{ request['total_weight'] }}</td>
                                <td> {{ request['total_sack'] }}</td>
                                <td> <span class="badge badge-success"> Selesai </span></td>
                                <td> {{ request['date'] }}</td>
                                <td>
                                    <a :href="`/stock/a/request/history/${request['user_id']}/${request['id']}/download`" target="_blank" type="button" class="btn btn-default rounded-circle"><i class="fad fa-file-download"></i></a>
                                    <button class="btn btn-info rounded-circle" @click="openModalDetails(request['id'])"><i class="fad fa-info"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- /.card-body -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-details" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content" v-if="stockSelected.length > 0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Data Permintaan Persediaan SJ: <b>{{ stockSelected[0]['id'] }}</b> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-border">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SKU</th>
                                        <th>Nama</th>
                                        <th>Harga/RP</th>
                                        <th>Total</th>
                                        <th>Total Berat/KG</th>
                                        <th>Total Karung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(stock, index) in stockSelected[0]['stock_request_confirmation_items']" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ stock['sku'] }}</td>
                                        <td>{{ stock['product_name'] }}</td>
                                        <td>{{ stock['price'] }}</td>
                                        <td>{{ stock['total'] }}</td>
                                        <td>{{ stock['weight'] }}</td>
                                        <td>{{ stock['sack'] }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-center font-weight-bolder"><i class="fad fa-abacus"></i> TOTAL </td>
                                        <td> {{ stockSelected[0]['total_stock'] }} </td>
                                        <td> {{ stockSelected[0]['total_weight'] }} </td>
                                        <td> {{ stockSelected[0]['total_sack'] }} </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Close</button>
<!--                        <a :href="`/stock/a/request/${stockSelected[0]['user_id']}/order/${stockSelected[0]['id']}/download?type=history`" target="_blank" type="button" class="btn btn-primary"><i class="fad fa-file-download"></i> Download</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Swal from 'sweetalert2'
import pagination from 'laravel-vue-pagination'

export default {
    name: "RequestStockHistory",
    props: ['requests'],
    components: {
        Swal,
        pagination
    },
    data(){
        return {
            sj: "",
            stockSelected: {}
        }
    },
    methods:{
        openModalDetails(id){

            this.stockSelected = this.requests.filter(value => {
                return value['id'] === id
            })

            $("#modal-details").modal('show')

        }
    },
    filters: {
        isConfirmed(status){
            switch (status) {
                case 1:
                    return '<span class="badge badge-success">TERKONFIRMASI</span>';
                default:
                    return '<span class="badge badge-danger">BELUM</span>';
            }
        },
    }
}
</script>

<style scoped>

</style>
