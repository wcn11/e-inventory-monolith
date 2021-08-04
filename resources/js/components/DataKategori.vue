<template>

    <table id="data-kategori" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Posisi</th>
            <th>status</th>
            <th>Deskripsi</th>
            <th>Terakhir Diubah</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="(i, index) in data" :key="index">
                <td> {{ i.id }}</td>
                <td> {{ i.name }} </td>
                <td> {{ i.position }} </td>
                <td> {{ i.is_enable }}</td>
                <td> {{ i.description }}</td>
                <td> {{ i.updated_at | formatDate }}</td>
<!--                disini import momentjs (jadiin module global)-->
                <td>
                    <a :href="`/category/edit/${i.id}`" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger" @click="openModal(i.id)" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        </tbody>

        <div class="modal fade" id="modal-danger">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Kategori</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda Yakin Ingin Menghapus Kategori Ini?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal"><i class="fas fa-minus-hexagon"></i> Batal</button>
                        <form class="form-delete" :action="`/category/destroy/${idSelected}`" method="post">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" class="token_delete" name="_token">
                            <button type="submit" class="btn btn-outline-light"><i class="fas fa-trash-alt"></i> Tetap Hapus</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </table>
</template>

<script>
import jquery from 'jquery'
import moment from 'moment'
moment.locale('id');

export default {
    name: "DataKategori",
    props: [
        'data',
        'csrf'
    ],
    components: {
        moment
    },
    data(){
        return {
            idSelected: 0,
        }
    },
    methods: {
        openModal(id){
            this.idSelected = id
            jquery("#modal-danger").modal('show')
        },
        deleteCategory(){
            let category = axios.delete(`/api/category/destroy/${this.idSelected}`)
            .then(res => {
                if (res){
                    location.reload()
                }
            }).catch(err => {
                console.log(err)
                })
        },
        setCSRF(){
            $(".token_delete").val(this.csrf)
        }
    },
    filters:{
        formatDate(date){
            return moment(date).format('DD-MM-yyyy, HH:mm');
        }
    },
    mounted() {
        this.setCSRF()
    }
}
</script>

<style scoped>

</style>
