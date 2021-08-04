<template>
    <div>
        <a href="#" class="btn btn-danger" @click="openModal" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i></a>
<!--        <form action="/delete/"></form>-->
    </div>
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
                }).then( async (result) => {

                    const response = await axios.delete(`api/${this.route}/${this.id}`)
                        .then(result => {
                                window.location.href = result.data.route
                        }).
                            catch(err => console.log(err))

                    console.log(response)
                    // if (result.isConfirmed) {
                    //     window.location.href = this.route
                    // }
                })

                const element = document.querySelector('.swal2-modal');
                element.style.display = "block"
            }
        }

    }
</script>
