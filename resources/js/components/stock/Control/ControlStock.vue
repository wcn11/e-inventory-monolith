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
                        <h1 class="m-0 p-4"><i class="fad fa-abacus"></i> Permintaan Persediaan</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div v-if="userSelected">

                        <div class="card-tools m-2">
                            <a :href="`/stock/a/request/${userSelected}/order`" class="btn btn-success"><i class="fad fa-handshake"></i> Buat Permintaan Barang</a>
                        </div>
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
