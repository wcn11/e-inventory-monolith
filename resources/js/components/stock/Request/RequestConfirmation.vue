<template>
    <div class="row">

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-hand-holding-box"></i>No. Pesanan <b>{{ request['id'] }}</b></h1>
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
                                <th>Nama</th>
                                <th class="text-center">Harga/KG</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Total Berat/KG</th>
                                <th class="text-center">Total Karung</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(stock, index) in products['stock_request_process_items']" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ stock['sku'] }}</td>
                                <td>{{ stock['product_name'] }}</td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkPriceInput(stock['id'], 'price')" pattern="[0-9]*" v-model.number="stock['price']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkRequestInput(stock['id'], 'total')" pattern="[0-9]*" v-model.number="stock['total']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkRequestInput(stock['id'], 'weight')" pattern="[0-9]*" v-model.number="stock['weight']" class="form-control form-control-border text-center">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkRequestInput(stock['id'], 'sack')" pattern="[0-9]*" v-model.number="stock['sack']" class="form-control form-control-border text-center">
                                    </div>
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
                        <small><i class="fad fa-info-circle"></i> Data Persediaan Pada Pihak <b>Accurate</b> Akan Di Update!</small>
                    </div>
                    <div class="modal-footer justify-content-around">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="confirmed"><i class="fad fa-check-double"></i> Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-danger accurate-reconnect" role="alert">
            <form :action="process.env.ACCURATE_HOST" method="post">
            Accurate Tidak Terhubung! Data Persediaan Tidak Akan Di Update. <button type="submit" class="btn btn-outline-secondary alert-link">HUBUNGKAN SEKARANG</button>.
            <input type="hidden" name="client_id" :value="process.env.ACCURATE_CLIENT_ID" />
            <input type="hidden" name="response_type" :value="process.env.ACCURATE_RESPONSE_TYPE" />
            <input type="hidden" name="redirect_uri" :value="process.env.ACCURATE_URL_CALLBACK"/>
            <input type="hidden" name="scope" value="purchase_invoice_view purchase_invoice_save" />
            </form>
        </div>
    </div>
</template>

<script>

import Swal from "sweetalert2";
import moment from "moment";

export default {
    name: "RequestConfirmation",
    props: ['request'],
    components: {
    },
    data(){
        return {
            products: this.request
        }
    },
    methods:{
        confirmed(){

          axios.put(`/api/stock/request/confirm/${this.products['id']}`, {
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

                    console.log(err.response.data)

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
        checkPriceInput(id, type = "price"){

            this.products['stock_request_process_items'].filter((value, index) => {

                let data = value['id'] === id

                if (data){
                    if (value[type] === ""){
                        this.products['stock_request_process_items'][index][type] = 0
                        this.setToastr("error", "Minimal Data Dimasukkan Adalah 0, Tidak Boleh Kosong!")
                        return 0
                    }

                }
            })
        },
        checkRequestInput(id, type){

            return this.products['stock_request_process_items'].filter((value, index) => {

                let data = value['id'] === id

                if (data){
                    if (value[type] !== ""){
                        return value[type]
                    }
                    this.products['stock_request_process_items'][index][type] = 0
                    this.setToastr("error", "Minimal Data Dimasukkan Adalah 0, Tidak Boleh Kosong!")
                    return 0
                }

            })
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
    }
}
</script>

<style scoped>

</style>
