<template>
    <div class="row">

        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-abacus"></i> Permintaan Persediaan Pada RPA</h1>
                    </div>
                </div>
                <div class="card-body">

                    <h4 class="m-2 p-2"><i class="fad fa-clipboard-list-check"></i> Daftar Permintaan Persediaan</h4>

                    <button class="btn btn-success text-right m-2" @click="openModalProduct"><i class="fad fa-layer-plus"></i> Tambahkan Produk</button>
                    <button v-if="selectedProduct.length > 0" class="btn btn-dark text-right m-2" @click="openModalConfirmation"><i class="fad fa-layer-plus"></i> Selesaikan Permintaan</button>

                    <div class="table-responsive">
                        <table class="table table-hover table-border">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Persediaan Yang Diminta (PCS)</th>
                                <th>Total Berat</th>
                                <th>Total Karung (Karung)</th>
                                <th>Hapus Produk</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="selectedProduct.length > 0" v-for="(stock, index) in selectedProduct" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ stock['name'] }}</td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <input type="text" @keypress="numberOnly" @change="checkRequestInput(stock['id'])" pattern="[0-9]*" v-model.number="stock['total_order']" class="form-control form-control-border text-center" name="user" :id="`p-${stock['id']}`">
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ stock['total_weight'] }}
                                </td>
                                <td class="text-center">
                                    {{ stock['total_sack'] }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-default remove-product" @click="removeProduct(stock['id'])"><i class="fad fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <tr v-if="selectedProduct.length <= 0">
                                <td colspan="6" class="text-center">Tidak Ada Produk Untuk Di Pesan. Tambahkan Produk Dahulu</td>
                            </tr>
                            </tbody>

                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-request" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Daftar Produk Dengan Stok Yang Tersedia Pada RPA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-border" id="table-product">
                                <thead>

                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Bobot</th>
                                    <th colspan="3">
                                        <p>Karung</p>
                                        <div class="row">
                                            <div class="col sm-4">Isi Karung</div>
                                            <div class="col sm-4">Berat Min.</div>
                                            <div class="col sm-4">Berat Maks.</div>
                                        </div>
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="product" v-for="(product, index) in products" :key="index">

                                    <td> {{ product.id }}</td>
                                    <td> {{ product.sku }} </td>
                                    <td> {{ product.name }} </td>
                                    <td> {{ product.category.name }} </td>
                                    <td> {{ product.price | formatMoney }}</td>
                                    <td> {{ product.weight}}</td>
                                    <td> {{ product.sack.length > 0 ? product.sack[0].contents : 0}}</td>
                                    <td> {{ product.sack.length > 0 ? product.sack[0].weight_min : 0}}</td>
                                    <td> {{ product.sack.length > 0 ? product.sack[0].weight_max : 0}}</td>
                                    <td>
                                        <button class="btn btn-default" @click="addProduct(product['id'])"><i class="fad fa-plus-circle"></i></button>
                                    </td>
                                </tr>
                                <!--                                    <tr v-if="products['data'].length <= 0">-->
                                <!--                                        <td colspan="5" class="text-center">Tidak Ada Produk Untuk Di Pilih</td>-->
                                <!--                                    </tr>-->
                                </tbody>
                            </table>
                            <!--                            <pagination :data="products" @pagination-change-page="getProducts"></pagination>-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-confirmation" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Permintaan Persediaan Pada RPA </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-inline">
                            <label for="sj">No. Surat Jalan : </label>
                            <input type="text" name="sj" v-model="sj" class="form-control form-control-border form-control-sm ml-2" id="sj" placeholder="Surat Jalan">

                            <div class="form-check ml-2 mb-2 mr-sm-2">
                                <input class="form-check-input form-control-lg" type="checkbox" id="inlineFormCheck" @click="setAutoSJ($event)">
                                <label class="form-check-label" for="inlineFormCheck">
                                    Penomoran Otomatis
                                </label>
                            </div>
                        </div>

                        <div class="form-inline">
                            <label for="pj">Penanggung Jawab (PJ) : </label>
                            <input type="text" name="pj" v-model="pj" class="form-control form-control-border form-control-sm ml-2" id="pj" placeholder="Penanggung Jawab">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-border">
                                <thead>
                                <tr class="align-middle">
                                    <th>No</th>
                                    <th>SKU</th>
                                    <th>Nama</th>
                                    <th class="text-center">Berat Satuan (KG)</th>
                                    <th class="text-center">Total Berat (KG)</th>
                                    <th class="text-center">Total Permintaan (PCS)</th>
                                    <th class="text-center">
                                        Total Permintaan (Karung)
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="selectedProduct.length > 0" v-for="(stock, index) in selectedProduct" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ stock['sku'] }}</td>
                                    <td>{{ stock['name'] }}</td>
                                    <td class="text-center">{{ stock['weight'] }}</td>
                                    <td class="text-center">{{ stock['total_weight'] }}</td>
                                    <td class="text-center"><b>{{ stock['total_order'] }}</b></td>
                                    <td class="text-center">{{ stock['total_sack'] }}/karung</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr class="tex25t-center" v-if="selectedProduct.length > 0">
                                    <td colspan="4"><b>Total</b></td>
                                    <td><b>{{ total_weight }} KG</b></td>
                                    <td><b>{{ total_order }} PCS</b></td>
                                    <td><b>{{ total_sack }} Karung</b></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-around">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Tutup</button>
                        <button type="button" class="btn btn-success" @click="requestConfirmed"><i class="fad fa-clipboard-check"></i> Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Swal from "sweetalert2";
import moment from "moment";
import pagination from 'laravel-vue-pagination'

export default {
    name: "RequestOrder",
    props: ['product', 'user_id'],
    components: {
        Swal,
        pagination
    },
    data(){
        return {
            products: this.product,
            selectedProduct: [],
            sj: "",
            pj: "",
            total_weight: 0,
            total_order: 0,
            total_sack: 0
        }
    },
    methods: {
        requestConfirmed(){

            axios.post(`/api/stock/request/store/${this.sj}`, {
                "user_id": this.user_id,
                "stock": this.selectedProduct,
                "total_order": this.total_order,
                "total_sacks": this.total_sack,
                "total_weight": this.total_weight,
                "sj": this.sj,
                "pj": this.pj
            }).then(results => {

                if (results.data.success){

                    let data = results.data['data']
                    // window.open(`${data['link']}`,'_blank');
                    this.setToastr("success", `Permintaan Stok Berhasil Dipesan Kepada ${this.user['name']}`)

                    this.selectedProduct = []
                    this.sj = ""
                    this.pj = ""

                    $("#modal-confirmation").modal('hide')

                    // window.location.href = '/stock/a'

                }

            }).catch(err => {
                this.setToastr("error", "Terjadi Error! Silahkan Muat Ulang Halaman!")
            })

        },
        openModalConfirmation(){
            let total = 0
            let weight = 0.0
            let sack = 0

            this.selectedProduct.forEach(item => {
                weight += item['total_weight']
                total += item['total_order']
                sack += item['total_sack']
            })

            this.total_weight = weight
            this.total_order = total
            this.total_sack = sack

            $("#modal-confirmation").modal('show')

        },
        openModalProduct() {

            $("#modal-request").modal('show')

        },
        addProduct(id) {
            let product = this.products.filter((value, index) => {
                if (value['id'] === id) {
                    value['total_order'] = value['sack'][0]['contents']
                    value['total_sack'] = Math.round(value['total_order'] / value['sack'][0]['contents'])
                    value['total_weight'] = value['total_order'] * value['weight']
                    this.selectedProduct.push(value)
                    this.products.splice(index, 1)
                }
            })
        },
        removeProduct(id){
            this.selectedProduct.filter((value, index) => {
                if (value['id'] === id){
                    this.selectedProduct.splice(index, 1);
                    delete value['total_order']
                    delete value['total_sack']
                    delete value['total_weight']
                    this.products.push(value)
                }
            })
        },
        checkRequestInput(id) {
            let product = this.selectedProduct.filter(value => {
                return value['id'] === id
            })

            if (product[0]['total_order'] <= 0 || product[0]['total_order'] === "" || product[0]['total_order'] < product[0]['sack'][0]['contents']) {

                product[0]['total_order'] = product[0]['sack'][0]['contents']
                product[0]['total_sack'] = 1
                let weight = product[0]['sack'][0]['contents'] * product[0]['weight']
                product[0]['total_weight'] = parseFloat(weight.toFixed(2))
                this.setToastr("error", "Permintaan Persediaan Yang DiMasukkan Minimal Sama Dengan 1 Isi Karung, atau Hapus Produk Jika Tidak Memesan!")

            } else {
                product[0]['total_sack'] = Math.ceil(product[0]['total_order'] / product[0]['sack'][0]['contents'])
                let weight = product[0]['total_order'] * product[0]['weight']
                product[0]['total_weight'] = parseFloat(weight.toFixed(1))
                return product[0]['total_order']
            }

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
        setToastr(type = "success", message = "Tidak Sesuai Format") {

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
        getSumWeight(){
            let total = 0

            this.selectedProduct.forEach(item => {
                total += parseFloat(item['total_weight'])
            })

            return total
        },
        getSumRequest(){
            let total = 0

            this.selectedProduct.forEach(item => {
                total += item['total_order']
            })

            return total
        },
        getSumSack(){

            let total = 0

            this.selectedProduct.forEach(item => {
                total += item['total_sack']
            })

            return total

        },
        setAutoSJ(event){

            if (event.target.checked){
                let sj = Math.random().toString(36).replace('0.', '')
                return this.sj =  sj.substr(0, 7).toUpperCase()
            }

            this.sj = ""
        },
    },
    filters: {
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
#eye {
    position:absolute;
    right:50px;
    top:26px;
}
</style>
