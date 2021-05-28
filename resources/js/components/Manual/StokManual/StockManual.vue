<template>
    <div>
    <span :class="'input-stock-' + index" @click="changeStock(index)" v-if="rowSelected !== index">314</span>
    <div v-else>
        <div class="d-inline-block">
            <div class="form-group">
                <label>Stock Baru:</label>
                <input type="text" name="stock[]" :class="'form-control form-control-border input-stock-' + index" v-model="stock"  onkeydown="return event.keyCode !== 69">
            </div>
        </div>
        <div class="d-inline-block">
            <div class="form-group">
                <label class="w-100"></label>
                <button class="btn btn-success rounded-circle ml-2" :class="{ 'disabled': !stock }" @click="updateStock(i)"><i class="fas fa-check"></i> </button>
            </div>
        </div>
    </div>

    </div>
</template>

<script>
import $ from "jquery";

export default {
    name: "StockManual",
    props: [
        'index'
    ],
    data(){
      return {
          stock: 0,
          rowSelected: 0
      }
    },
    methods: {
        changeStock(index){

            $(`.input-stock-${index}`).css({
                'display': 'none'
            })

            this.rowSelected = index
        },
        changePrice(index){
        },
        updateStock(index){
            this.rowSelected = 0
        }
    },
    filters: {
        formatMoney(){
            let stock =  /^-?\d*$/.test(this.stock);
            return stock
        }
    }
}
</script>

<style scoped>

</style>
