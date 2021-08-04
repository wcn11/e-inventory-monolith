<template>
    <div class="row">

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-hand-holding-box"></i>Surat Jalan</h1>
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
                                <th>Di Proses</th>
                                <th>Tanggal</th>
                                <th>Rincian</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(request, index) in stocks" :key="index">
                                <td> {{ request['id'] }}</td>
                                <td> {{ request['pj'] }} </td>
                                <td> {{ request['origin'] }} </td>
                                <td> {{ request['destination'] }} </td>
                                <td> {{ request['total_stock'] }}</td>
                                <td> {{ request['total_weight'] }}</td>
                                <td> {{ request['total_sack'] }}</td>
                                <td> <span class="badge badge-warning"> Belum </span></td>
                                <td> {{ request['date'] }}</td>
                                <td>
                                    <a :href="`/stock/a/request/${request['user_id']}/order/${request['id']}/download`" target="_blank" type="button" class="btn btn-default rounded-circle"><i class="fad fa-file-download"></i></a>
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

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-clipboard-list-check"></i> Persediaan Yang Sedang Di Proses</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-border table-hover" id="table-process">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>PJ</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Total Permintaan (PCS)</th>
                                <th>Total Permintaan (KG)</th>
                                <th>Total Permintaan (Karung)</th>
                                <th>Di Proses</th>
                                <th>Tanggal</th>
                                <th>Rincian</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(request, index) in request" :key="index">
                                <td> {{ request['id'] }}</td>
                                <td> {{ request['pj'] }} </td>
                                <td> {{ request['origin'] }} </td>
                                <td> {{ request['destination'] }} </td>
                                <td> {{ request['total_stock'] }}</td>
                                <td> {{ request['total_weight'] }}</td>
                                <td> {{ request['total_sack'] }}</td>
                                <td> <span class="badge badge-warning"> Belum </span></td>
                                <td> {{ request['date'] }}</td>
                                <td>
                                    <a :href="`/stock/a/request/${request['user_id']}/order/${request['id']}/download`" target="_blank" type="button" class="btn btn-default rounded-circle"><i class="fad fa-file-download"></i></a>
                                    <button class="btn btn-info rounded-circle" @click="openModalProcessDetails(request['id'])"><i class="fad fa-info"></i></button>
                                    <a :href="`/stock/a/request/${request['user_id']}/order/${request['id']}/confirmation`" class="btn btn-warning rounded-circle"><i class="fad fa-truck-loading"></i> Proses</a>
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
                                    <th>Harga/KG</th>
                                    <th>Total</th>
                                    <th>Total Karung</th>
                                    <th>Total Berat/KG</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(stock, index) in stockSelected[0]['stock_request_items']" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ stock['sku'] }}</td>
                                    <td>{{ stock['product_name'] }}</td>
                                    <td>{{ stock['price'] |formatMoney }}</td>
                                    <td>{{ stock['total'] }}</td>
                                    <td>{{ stock['sack'] }}</td>
                                    <td>{{ stock['weight'] }}</td>
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
                        <a :href="`/stock/a/request/${stockSelected[0]['user_id']}/order/${stockSelected[0]['id']}/download`" target="_blank" type="button" class="btn btn-primary"><i class="fad fa-file-download"></i> Download</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-process-details" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content" v-if="stockProcessSelected.length > 0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropProcessLabel">Data Permintaan Persediaan SJ: <b>{{ stockProcessSelected[0]['id'] }}</b> </h5>
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
                                    <th>Harga/KG</th>
                                    <th>Total</th>
                                    <th>Total Karung</th>
                                    <th>Total Berat/KG</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(stock, index) in stockProcessSelected[0]['stock_request_process_items']" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ stock['sku'] }}</td>
                                    <td>{{ stock['product_name'] }}</td>
                                    <td>{{ stock['price'] | formatMoney }}</td>
                                    <td>{{ stock['total'] }}</td>
                                    <td>{{ stock['sack'] }}</td>
                                    <td>{{ stock['weight'] }}</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center font-weight-bolder"><i class="fad fa-abacus"></i> TOTAL </td>
                                    <td> {{ stockProcessSelected[0]['total_stock'] }} </td>
                                    <td> {{ stockProcessSelected[0]['total_sack'] }} </td>
                                    <td> {{ stockProcessSelected[0]['total_weight'] }} </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Close</button>
                        <a :href="`/stock/a/request/${stockProcessSelected[0]['user_id']}/order/${stockProcessSelected[0]['id']}/download`" target="_blank" type="button" class="btn btn-primary"><i class="fad fa-file-download"></i> Download</a>
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
    name: "StockRequest",
    props: ['stocks', 'request'],
    components: {
        Swal,
        pagination
    },
    data(){
        return {
            sj: "",
            stockSelected: {},
            stockProcessSelected: {}
        }
    },
    methods:{
        openModalProcessDetails(id){

            this.stockProcessSelected = this.request.filter(value => {
                return value['id'] === id
            })

            $("#modal-process-details").modal('show')
        },
        openModalDetails(id){

            this.stockSelected = this.stocks.filter(value => {
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
        formatMoney(val){
            let formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });

            return formatter.format(val);
        }
    }
}
</script>

<style scoped>

</style>
