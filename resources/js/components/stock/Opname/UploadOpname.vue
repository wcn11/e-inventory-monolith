<template>
    <div class="row">

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-hand-holding-box"></i>No. Pesanan: <b>{{ request['id'] }}</b></h1>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <p>Asal: {{ request['origin'] }}</p>
                            <p>Destinasi: {{ request['destination'] }}</p>
                            <p>Tanggal: {{ request['date'] | formatDate }}</p>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-success" @click="openModalConfirmation"><i class="fad fa-clipboard-check"></i> Konfirmasi Pesanan</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-border" id="table-confirmation">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>SKU</th>
                                <th>Produk</th>
                                <th class="text-center">Harga/KG</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Total Karung</th>
                                <th class="text-center">Total Berat/KG</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(stock, index) in products['stock_request_items']" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ stock['sku'] }}</td>
                                <td>{{ stock['product_name'] }}</td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkPriceInput(stock['id'])" pattern="[0-9]*" v-model.number="stock['price']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkRequestInput(stock['id'], 'total')" pattern="[0-9]*" v-model.number="stock['total']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ stock['sack'] }}
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkWeightInput(stock['id'], 'weight')" pattern="[0-9]*" v-model.number="stock['weight']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr class="text-center bg-dark">
                                    <td colspan="4">Total</td>
                                    <td>
                                        {{ products['total_stock'] }}
                                    </td>
                                    <td>
                                        {{ products['total_sack'] }}
                                    </td>
                                    <td>
                                        {{ products['total_weight'] }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- /.card-body -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-confirmation" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-warning">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Permintaan Persediaan SJ: <b>{{ request['id'] }}</b> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda Yakin Telah Selesai Dan Teliti Secara Cermat Menghitung Ulang Pesanan Persediaan ?</p>
                    </div>
                    <div class="modal-footer justify-content-around">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="confirmed"><i class="fad fa-check-double"></i> Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Swal from "sweetalert2";
import moment from "moment";

export default {
    name: "UploadOpname",
    props: ['request'],
    components: {
    },
    data(){
        return {
            products: this.request,
        }
    },
    methods:{
        confirmed(){

            axios.post(`/api/stock/request/process/${this.products['id']}`, {
                "request": this.products
            })
                .then(results => {

                    if (results.data.success){

                        this.setToastr("success", "Surat Jalan Berhasil Di konfirmasi!")

                        window.location.href = "/stock/request-stock"

                    }
                })
                .catch(err => {

                    if(err.response.data.success === false){

                        this.setToastr("success", err.response.data.message)
                    }
                })
        },
        openModalConfirmation() {

            $("#modal-confirmation").modal('show')

        },
        numberOnly(evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        checkWeightInput(id, type = "weight"){

            let total = 0

            this.products['stock_request_items'].filter((value, index) => {

                let data = value['id'] === id

                if (data){
                    if (value[type] === ""){
                        this.products['stock_request_items'][index][type] = 0
                        this.setToastr("error", "Minimal Data Dimasukkan Adalah 0, Tidak Boleh Kosong!")
                        return 0
                    }
                }

                total += value[type]
            })

            this.products['total_weight'] = total.toFixed(2)
        },
        checkPriceInput(id, type = "price"){

            this.products['stock_request_items'].filter((value, index) => {

                let data = value['id'] === id

                if (data){
                    if (value[type] === ""){
                        this.products['stock_request_items'][index][type] = 0
                        this.setToastr("error", "Minimal Data Dimasukkan Adalah 0, Tidak Boleh Kosong!")
                        return 0
                    }

                }
            })
        },
        checkRequestInput(id, type){

            let totals = 0
            let weights = 0
            let sacks = 0

            this.products['stock_request_items'].filter((value, index) => {

                let data = value['id'] === id

                if (data){
                    if (value[type] === ""){
                        this.products['stock_request_items'][index][type] = 0
                        this.setToastr("error", "Minimal Data Dimasukkan Adalah 0, Tidak Boleh Kosong!")
                        return 0
                    }

                    value['sack'] = Math.ceil(value['total'] / value['products']['sack'][0]['contents'])
                    let weight = value['total'] * value['weight_per_unit']

                }

                totals += value['total']
                sacks += value['sack']
            })

            this.products['total_stock'] = totals
            this.products['total_sack'] = sacks

        },
        setToastr(type = "success", message = "Tidak Sesuai Format"){

            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: type,
                title: message
            })
        },
    },
    filters: {
        formatDate(date){
            return moment(date).format('DD MMMM yyyy, HH:mm');
        }
    },
}
</script>

<style scoped>

</style>
