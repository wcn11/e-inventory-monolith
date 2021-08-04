<template>

    <table id="data-pengguna" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>status</th>
            <th>Region</th>
            <th>Otoritas</th>
            <th>Di Daftarkan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(i, index) in data" :key="index">
            <td> {{ i.id }}</td>
            <td> {{ i.name }} </td>
            <td> {{ i.email }} </td>
            <td> {{ i.is_enable ? i.is_enable : 'off' }}</td>
            <td> {{ i.province.length > 0 ? i.province[0].name : "Belum Dipilih" }} </td>
            <td>
                <span class="badge badge-secondary" v-for="role in i.roles" :key="role.id">
                    {{ role.name }}
                </span>
            </td>
            <td> {{ i.created_at | formatDate }}</td>
            <td>
                <a :href="`/user/edit/${i.id}`" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit Kategori"><i class="fas fa-edit"></i></a>
                <modal-delete-confirmation :id="`${i.id}`"  :route="`user/delete`"></modal-delete-confirmation>
<!--                <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>-->
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import moment from 'moment'
import ModalDeleteConfirmation from "./Helper/ModalDeleteConfirmation";

moment.locale('id');

export default {
    name: "UserData",
    props: [
        'data'
    ],
    components: {
        moment,
        ModalDeleteConfirmation
    },
    filters:{
        formatDate(date){
            return moment(date).format('DD-MM-yyyy, HH:mm');
        }
    }
}
</script>

<style scoped>

</style>
