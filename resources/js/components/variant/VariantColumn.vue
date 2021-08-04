<template>

    <div class="form-row p-2">
        <div class="col">
            <input type="text" class="form-control form-control-border" id="sku" placeholder="Kode SKU" required>
        </div>
        <div class="col">
            <input type="text" class="form-control form-control-border" id="name" placeholder="Nama Produk" required>
        </div>
        <div class="col">
            <input type="text" class="form-control form-control-border" id="price" placeholder="Harga Produk" required onkeydown="return event.keyCode !== 69" pattern="\d*">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-border" id="weight" placeholder="Berat Produk (Kilogram). Contoh: 1.5" required onkeydown="return event.keyCode !== 69">
        </div>
        <div class="col">
            <select class="custom-select form-control-border" name="position" id="position" required onkeydown="return event.keyCode !== 69">
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
        </div>
        <div class="col text-center">
            <select class="custom-select form-control-border" name="category" id="category" required onkeydown="return event.keyCode !== 69">
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
        </div>
        <div class="col">
            <textarea class="form-control form-control-border" id="description" rows="6" placeholder="Masukan deskripsi ..." required></textarea>
        </div>
    </div>
</template>

<script>
import BootstrapSwitch from 'bootstrap-switch'
export default {
    name: "VariantColumn",
    props: [
      'id',
    ],
    components:{
      BootstrapSwitch,
    },
    data(){
        return {
            variant: false
        }
    },
    methods: {
      checkboxSwitch(){
              jQuery("#variant-" + this.id).bootstrapSwitch();
      },
        removeVariant(){
          this.$emit('removeVariant', this.id);
        }
    },
    computed: {

    },
    mounted() {
        this.checkboxSwitch()
    }
}
</script>

<style scoped>

</style>
