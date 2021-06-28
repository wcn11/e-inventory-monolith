<template>
    <a href="#" class="btn btn-danger" @click="openModal" data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><i class="fas fa-trash-alt"></i></a>
</template>

<script>
    export default {
        name: "ModalDeleteConfirmation",
        props: ['id', 'route'],
        methods: {
            openModal(){
                this.$swal({
                    title: 'Apakah Anda Yakin?',
                    text: "Semua Data Akan Langsung Terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.route
                    }
                })

                const element = document.querySelector('.swal2-modal');
                element.style.display = "block"
            }
        }

    }
</script>
