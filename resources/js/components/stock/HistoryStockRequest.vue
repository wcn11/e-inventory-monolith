<template>

    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"><i class="fad fa-clipboard-list-check"></i> Permintaan Stok:</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
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
                                    <th>Tanggal</th>
                                    <th>Terkonfirmasi</th>
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
                                    <td> {{ request['date'] }}</td>
                                    <td :inner-html.prop="request['is_confirmed'] | isConfirmed"></td>
                                    <td>
                                        <button class="btn btn-info rounded-circle" @click="openModalDetails(request['id'])"><i class="fad fa-info"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->

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
                                    <th>Berat Satuan/KG</th>
                                    <th>Total</th>
                                    <th>Total Berat/KG</th>
                                    <th>Total Karung</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(stock, index) in stockSelected[0]['stock_request_items']" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ stock['sku'] }}</td>
                                    <td>{{ stock['product_name'] }}</td>
                                    <td>{{ stock['weight_per_unit'] }}</td>
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
                        <a :href="`/stock/a/request/${stockSelected[0]['user_id']}/order/${stockSelected[0]['id']}/download`" target="_blank" type="button" class="btn btn-primary"><i class="fad fa-file-download"></i> Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import jquery from 'jquery'
import moment from 'moment'

moment.locale('id');

export default {
    name: "HistoryStockRequest",
    props: ['stocks'],
    data(){
        return {
            stockSelected: {}
        }
    },
    methods: {
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
    }
}
</script>

<style scoped>
    #file{
        cursor: pointer;
    }
</style>
