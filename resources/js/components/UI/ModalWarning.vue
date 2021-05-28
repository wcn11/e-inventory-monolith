<template>

    <div class="modal fade" id="modal-warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Variant ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Menghapus variant ini ?&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-ban"></i> Batalkan</button>
                    <button type="button" class="btn btn-outline-dark" @click="removeVariant"><i class="fas fa-times"></i> Hapus Variant</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</template>

<script>
import jquery from "jquery";

export default {
    name: "ModalWarning",
    methods: {
        removeVariant(){
            this.$emit('removeVariant')
        },
        openModal(){
            jquery("#modal-warning").modal('show');
        }
    },
    mounted() {
        this.openModal()
    }
}
</script>

<style scoped>

</style>
