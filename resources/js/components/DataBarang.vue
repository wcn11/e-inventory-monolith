<template>
<div class="table-responsive">
    <table id="data-barang" class="table table-bordered table-hover">
        <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>SKU</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Posisi</th>
            <th>Status</th>
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
            <th>Deskripsi</th>
            <th>Terakhir Diubah</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(i, index) in data" :key="index">
            <td> {{ i.id }}</td>
            <td> {{ i.sku }} </td>
            <td> {{ i.name }} </td>
            <td> {{ i.category.name }} </td>
            <td> {{ i.position }} </td>
            <td> {{ i.is_enable }}</td>
            <td> {{ i.price | formatMoney}}</td>
            <td> {{ i.weight}}</td>
            <td> {{ i.sack.length > 0 ? i.sack[0].contents : 0}}</td>
            <td> {{ i.sack.length > 0 ? i.sack[0].weight_min : 0}}</td>
            <td> {{ i.sack.length > 0 ? i.sack[0].weight_max : 0}}</td>
            <td> {{ i.description }}</td>
            <td> {{ i.updated_at | formatDate }}</td>
            <td>
                <a :href="`/product/edit/${i.id}`" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Barang"><i class="fas fa-edit"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger" @click="openModal(i.id)" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        </tbody>

        <div class="modal fade" id="modal-danger">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda Yakin Ingin Menghapus Paroduk Ini?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal"><i class="fas fa-minus-hexagon"></i> Batal</button>
                        <form class="form-delete" :action="`/product/destroy/${idSelected}`" method="post">
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
</div>
</template>

<script>
import moment from 'moment'
import jquery from "jquery";
moment.locale('id');

export default {
    name: "DataBarang",
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
        setCSRF(){
            $(".token_delete").val(this.csrf)
        }
    },
    filters:{
        formatDate(date){
            return moment(date).format('DD-MM-yyyy, HH:mm');
        },
        formatMoney(val){
            let formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });

            return formatter.format(val);
        }
    },
    mounted() {
        this.setCSRF()
    }
}
</script>

<style scoped>

</style>
