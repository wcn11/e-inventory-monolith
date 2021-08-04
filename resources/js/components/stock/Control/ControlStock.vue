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
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in users" :key="index">
                                <td> {{ user.id }}</td>
                                <td> {{ user.name }} </td>
                                <td class="text-center">
                                    <input type="checkbox" name="user" class="form-control form-control-lg users" :id="`user-${user.id}`" @click="setSelectedUser(user.id)"/>
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
                        <h1 class="m-0 p-4"><i class="fad fa-abacus"></i> Persediaan</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div v-if="userSelected">

                        <div class="card-tools text-right m-2">
                            <a :href="`/stock/a/request/${userSelected}/order`" class="btn btn-success"><i class="fad fa-handshake"></i> Buat Permintaan Barang</a>
                        </div>
                        <div class="table-responsive">
<!--                            <div class="row">-->
<!--                                <div class="col-sm-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="show">Tampilkan</label>-->
<!--                                        <select id="show" class="form-control w-25" @change="getProducts()" v-model="paginate">-->
<!--                                            <option selected="selected" value="10">10</option>-->
<!--                                            <option value="25">25</option>-->
<!--                                            <option value="50">50</option>-->
<!--                                            <option value="100">100</option>-->
<!--                                            <option value="250">250</option>-->
<!--                                            <option value="500">500</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-sm-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="products">Cari</label>-->
<!--                                        <input id="products" type="text" name="product" class="form-control" v-debounce:500ms="getProducts" v-model="search">-->
<!--                                        <p> Total Data: {{ products['total'] }}</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <table class="table table-border table-hover">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SKU</th>
                                    <th>Nama Barang</th>
                                    <th>Status</th>
                                    <th>Total.</th>
                                    <th>Total Karung.</th>
                                    <th>Total Berat</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products[0].stock" :key="index">
                                        <td> {{ index + 1 }}</td>
                                        <td> {{ product['product']['sku'] }} </td>
                                        <td> {{ product['product']['name'] }} </td>
                                        <td> {{ product['product']['name'] }} </td>
                                        <td> {{ product['total'] }} </td>
                                        <td> {{ product['total_of_sack'] }} </td>
                                        <td> {{ product['total_weights'] }} </td>
<!--                                        <td>-->
<!--                                            <button class="btn btn-info rounded-circle" @click="openModalLimit(product.id)"><i class="fad fa-info"></i></button>-->
<!--                                        </td>-->
                                    </tr>
                                </tbody>
                            </table>
<!--                            <pagination :data="products" @pagination-change-page="getProducts"></pagination>-->
                        </div>
                    </div>
                    <div v-else>
                        <h2 class="text-center">Pilih Pengguna</h2>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ControlStock",
    props: ['users'],
    data(){
        return {
            userSelected: 0,
            products: []
        }
    },
    methods:{
        setSelectedUser(id){

            if(this.userSelected){
                document.querySelector('#user-' + this.userSelected).checked = false;
            }

            this.userSelected = id
            this.products = this.users.filter(value => {

                return value['id'] === id

            })

        },

    },
}
</script>

<style scoped>

</style>
