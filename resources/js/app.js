/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from  'vue'
import VueClip from 'vue-clip'
import './plugins/jquery-ui.css'

Vue.use(VueClip)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('user-data', require('./components/UserData.vue').default);
Vue.component('data-barang', require('./components/DataBarang.vue').default);
Vue.component('data-kategori', require('./components/DataKategori.vue').default);
Vue.component('product-variant-options', require('./components/variant/ProductVariantOptions.vue').default);
Vue.component('modal-warning', require('./components/UI/ModalWarning.vue').default);
Vue.component('upload-file', require('./components/UploadFile.vue').default);
Vue.component('chart-stock', require('./components/Chart/chart-stock.vue').default);
Vue.component('harga', require('./components/Manual/Harga.vue').default);
Vue.component('upload-stock', require('./components/stock/UploadStock').default);
Vue.component('stock-terbanyak', require('./components/Dashboard/StokTerbanyak').default);
Vue.component('stock-menipis', require('./components/Dashboard/StokMenipis').default);
Vue.component('stock-trip', require('./components/stock/StockTrip').default);
Vue.component('cek-stok', require('./components/stock/CekStock').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});