<template>
    <div>
        <span :class="'price-' + index" @click="changePrice(index)" v-if="rowSelected !== index">Rp 30.0000,00</span>
        <div v-else>
            <div class="d-inline-block">
                <div class="form-group">
                    <label>Harga Baru:</label>
                    <input type="number" name="price[]" :class="'form-control form-control-border input-price-' + i" v-model="price[index - 1]"  onkeydown="return event.keyCode !== 69">
                </div>
            </div>
            <div class="d-inline-block">
                <div class="form-group date">
                    <label>Tanggal Update:</label>
                    <input type="date" class="form-control datetimepicker-input" data-target="#reservationdate" min="2017-04-01" max="2017-04-20" required/>
                </div>
            </div>
            <div class="d-inline-block">
                <div class="form-group">
                    <label class="w-100"></label>
                    <button class="btn btn-success rounded-circle ml-2" @click="updatePrice(index)"><i class="fas fa-check"></i> </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";

export default {
    name: "HargaManual",
    props: [
        'index'
    ],
    data(){
        return {
            rowSelected: 0,
            price: []
        }
    },
    methods: {

        changePrice(index){

            $(`.price-${index}`).css({
                'display': 'none'
            })

            this.rowSelected = index
        },
        updatePrice(index){
            this.rowSelected = 0
        },
    }
}
</script>

<style scoped>
    .date{
        width: 20% !important;
    }
</style>
