<template>
    <!-- BAR CHART -->
    <div class="card card-success">
        <div class="form-group">
            <label for="is_has_variant">Varian <span class="text-danger">*</span></label>
            <input type="checkbox" class="form-control form-control-border" id="is_has_variant" name="is_has_variant" data-bootstrap-switch data-off-color="danger" data-on-color="success">
        </div>
        <div class="card-header">
            <h3 class="card-title">Varian Produk</h3>
            <div class="card-tools">

                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Tambah Variant Produk" @click="addVariant"><i class="fas fa-plus-circle"></i>
                </button>

                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>

                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <div class="form-row">
                <div class="col">
                    <label>Kode SKU:</label>
                </div>
                <div class="col">
                    <label>Nama:</label>
                </div>
                <div class="col">
                    <label>Ukuran (KG):</label>
                </div>
                <div class="col">
                    <label>Harga:</label>
                </div>
                <div class="col">
                    <label>Bobot:</label>
                </div>
                <div class="col text-center">
                    <label>Status:</label>
                </div>
                <div class="col">
                    <label>Aksi:</label>
                </div>
            </div>
                <variant-column :id="index" @removeVariant="removeWarning(index)" v-for="(i, index) in rows" :key="index"></variant-column>
        </div>
        <!-- /.card-body -->

        <modal-warning v-if="0 < is_any_variant_remove" @removeVariant="removeVariant"></modal-warning>

    </div>
    <!-- /.card -->
</template>

<script>
import VariantColumn from "./VariantColumn";
import jquery from 'jquery'
import Bootstrap from 'bootstrap'
export default {
    name: "ProductVariantOptions",
    components:{
        VariantColumn,
        jquery,
        Bootstrap,
    },
    data(){
        return {
            rows: [],
            is_any_variant_remove: 0
        }
    },
    methods: {
        addVariant(){
            this.rows.push({id: this.newId });
        },
        checkboxSwitch(){
            jQuery("#is_has_variant").bootstrapSwitch();
        },
        removeWarning(row){
            this.is_any_variant_remove = row + 1
        },
        removeVariant(row){
            this.rows.splice(this.rows.indexOf(this.is_any_variant_remove - 1), 1)
            jquery("#modal-warning").modal('hide');
            this.is_any_variant_remove = 0
        }
    },
    computed:{
        newId(){
            return this.rows.length == 0 ? 1 : Math.max(...this.rows.map(r => r.id)) + 1
        }
    },
    mounted() {
        this.checkboxSwitch()
    }
}
</script>

<style scoped>

</style>
