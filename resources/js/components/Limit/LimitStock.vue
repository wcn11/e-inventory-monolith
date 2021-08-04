<template>
    <div class="row">

        <div class="col-md-5">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-abacus"></i> Daftar Pengguna</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-pengguna" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>status</th>
                                    <th>Region</th>
                                    <th>Otoritas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in users" :key="index">
                                <td> {{ user.id }}</td>
                                <td> {{ user.name }} </td>
                                <td> {{ user.email }} </td>
                                <td> {{ user.is_enable ? user.is_enable : 'off' }}</td>
                                <td> {{ user.province.length > 0 ? user.province[0].name : "Belum Dipilih" }} </td>
                                <td>
                                    <span class="badge badge-secondary" v-for="role in user.roles" :key="role.id">
                                        {{ role.name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="user" class="form-control form-control-lg" :id="`user-${user.id}`" @click="setSelectedUser(user.id)"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <h1 class="m-0 p-4"><i class="fad fa-abacus"></i> Ambang Batas Persediaan</h1>
                    </div>
                </div>
                <div class="text-right p-2 m-0">
                    <p>Stock User</p>
                </div>
                <div class="card-body">
                    <div v-if="userSelected">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="show">Tampilkan</label>
                                        <select id="show" class="form-control w-25" @change="getProducts()" v-model="paginate">
                                            <option selected="selected" value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="250">250</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="products">Cari</label>
                                        <input id="products" type="text" name="product" class="form-control" v-debounce:500ms="getProducts" v-model="search">
                                        <p> Total Data: {{ products['total'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-border table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SKU</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Batas Min.</th>
                                        <th>Batas Maks.</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products.data" :key="index">
                                        <td> {{ products['from'] + index}}</td>
                                        <td> {{ product.sku }} </td>
                                        <td> {{ product.name }} </td>
                                        <td> {{ product.category.name }} </td>
                                        <td> {{ product.is_enable }}</td>
                                        <td>
                                            <span>{{ product['limits'] ? product['limits']['stock_min'] : 0 }}</span>
                                        </td>
                                        <td>
                                            <span>{{ product['limits'] ? product['limits']['stock_max'] : 0 }}</span>
                                        </td>
                                        <td>
                                            <button :class="{'invisible' : !product['limits']}" class="btn btn-outline-danger rounded-circle" @click="openModalDeleteLimit(product.id)"><i class="fad fa-minus-circle"></i></button>
                                            <button class="btn btn-info rounded-circle" @click="openModalLimit(product.id)"><i class="fad fa-info"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :data="products" @pagination-change-page="getProducts"></pagination>
                        </div>
                    </div>
                    <div v-else>
                        <h2 class="text-center">Pilih Pengguna</h2>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="modal fade" id="modal-limit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-warning">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Ambang Batas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="limit_min" class="col-sm-3 col-form-label">Batas Minimal</label>
                            <div class="col-sm-5">
                                <input type="text" name="limit_min" v-model="limit_min" @keydown="checkInput" class="form-control text-center limit" id="limit_min" value="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="limit_max" class="col-sm-3 col-form-label">Batas Maksimal</label>
                            <div class="col-sm-5">
                                <input type="text" name="limit_max" v-model="limit_max"  class="form-control text-center limit" id="limit_max" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal"><i class="fas fa-minus-hexagon"></i> Batal</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="updateLimit"><i class="fad fa-edit"></i> Simpan</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-delete-limit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title">Hapus Ambang Batas Persediaan Pengguna</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda Yakin Ingin Menghapus Ambang Batas Persediaan Ini ?</p>
                        <small><i class="fad fa-info-circle"></i> Stok Terkini Pada Pengguna Tidak Akan Terhapus</small> <br/>
                        <small><i class="fad fa-info-circle"></i> Ambang Batas Persediaan Pengguna Dapat Diatur Kembali</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-minus-hexagon"></i> Batal</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteLimit"><i class="fad fa-edit"></i> Tetap Hapus</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import pagination from 'laravel-vue-pagination'

export default {
    name: "LimitStock",
    props: ['users'],
    components: {
      Swal,
        pagination
    },
    data(){
        return {
            userSelected: 0,
            limit_min: 0,
            limit_max: 0,
            product: 0,
            products: {},
            paginate: "10",
            search: "",
            productWillDelete: {}
        }
    },
    methods: {
        async getProducts(page = 1){

            await axios.get(`/api/limit?paginate=${this.paginate}&page=${page}&user_id=${this.userSelected}&q=${this.search}`)
                .then(results => {
                    if (results.data.success){
                        this.products = results.data.data
                    }
                }).catch(err => {
                    this.setToastr()
                })

        },
        deleteLimit(){

            axios.delete(`/api/limit/${this.productWillDelete['id']}`)
                .then(results => {
                    if (results.data.success){
                        this.getProducts()
                        this.setToastr("success", "Berhasil Menghapus Ambang Batas")
                    }
                }).catch(err => {
                    if(err.response.data.success === false){

                        let message = err.response.data.message

                        this.setToastr("error", message)

                    }
                })

        },
        setSelectedUser(id ){

            if(this.userSelected){
                document.querySelector('#user-' + this.userSelected).checked = false;
            }
            this.userSelected = id

            this.getProducts()

        },
        openModalLimit(id){

            this.product = id

            const limits = this.products['data'].filter(value => {
                return value['id'] === id
            })

            this.limit_min = limits[0]['limits'] ? limits[0]['limits']['stock_min'] : 0
            this.limit_max = limits[0]['limits'] ? limits[0]['limits']['stock_max'] : 0

            $("#modal-limit").modal("show")

        },
        openModalDeleteLimit(id){

            const limits = this.products['data'].filter(value => {
                return value['id'] === id
            })

            this.productWillDelete = limits[0]

            $("#modal-delete-limit").modal("show")


        },
        async updateLimit(){
            await axios.put(`/api/limit/product`,{
                "user_id": this.userSelected,
                "product_id": this.product,
                "limit_min": this.limit_min,
                "limit_max": this.limit_max
            })
                .then(results => {
                    if (results.data.success){
                        this.limit = results.data.data
                        this.getProducts()
                        this.setToastr("success", "Berhasil Update Ambang Batas Persediaan Produk ")
                        this.limit_min = 0
                        this.limit_max = 0
                    }
                }).catch(err => {

                    if (typeof err.response.data.message === 'object'){

                        const length = Object.keys(err.response.data.message).length

                        if (length >= 1){
                            for(let i = 0; i < length; i++){
                                let key = Object.keys(err.response.data.message)[i];
                                this.setToastr("error", key)
                            }
                            return
                        }
                    }
                })
        },
        checkInput(){
            // filter number
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };

            $(".limit").inputFilter(function(value) {
                return /^-?\d*$/.test(value);
            });
        },
        setToastr(type = "error", message = "Terjadi Error, Silahkan Muat Ulang Halaman!"){

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
}
</script>

<style scoped>

</style>
