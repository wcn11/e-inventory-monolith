/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueClip from 'vue-clip'

import './plugins/jquery-ui.css'

import toastr from 'vue-toastr'

import VueSweetalert2 from 'vue-sweetalert2';

import VueLoaders from 'vue-loaders';
import 'vue-loaders/dist/vue-loaders.css';
import vueDebounce from 'vue-debounce'

Vue.use(vueDebounce)
// add plugin
Vue.use(VueLoaders);

Vue.use(toastr)
Vue.use(VueClip)
Vue.use(VueSweetalert2);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('pagination', require('laravel-vue-pagination'));
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
Vue.component('stock-request', require('./components/stock/StockRequest').default);
Vue.component('history-stock-request', require('./components/stock/HistoryStockRequest').default);
Vue.component('cek-stok', require('./components/stock/CekStock').default);
Vue.component('tabel-stok', require('./components/stock/TabelStock').default);
Vue.component('roles', require('./components/Roles/Roles').default);
Vue.component('roles-update', require('./components/Roles/RolesUpdate').default);
Vue.component('delete-confirmation', require('./components/Helper/ModalDeleteConfirmation').default);
Vue.component('success-toastr', require('./components/Utilities/Toastr').default);
Vue.component('opname', require('./components/stock/Opname/OpnameIndex').default);
Vue.component('opname-upload', require('./components/stock/Opname/UploadOpname').default);
Vue.component('limit-stock', require('./components/Limit/LimitStock').default);
Vue.component('control-stock', require('./components/stock/Control/ControlStock').default);
Vue.component('request-order', require('./components/stock/Control/RequestOrder').default);
Vue.component('request-stock', require('./components/stock/Request/RequestStock').default);
Vue.component('request-stock-history', require('./components/stock/Request/RequestStockHistory').default);
Vue.component('request-confirmation', require('./components/stock/Request/RequestConfirmation').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
      user_id: 0
    },
    methods:{
      // setNotifcation(){
      //       if (! ('Notification' in window)) {
      //           alert('Browser Tidak Mendukung Untuk Notifikasi!');
      //           return;
      //       }
      //
      //     if (Notification.permission === "denied"){
      //         alert('Perizinan Notifikasi Browser DiTolak! Anda Harus Mengaktifkan Perizinan Notifikasi Pada Browser Anda!');
      //     }
      //
      //   },
        getUser(){
            this.user_id = document.querySelector("meta[name='user-id']").getAttribute('content')
        },
        setAlertNotification(){
          if (Notification.permission === "denied"){
              if (window.confirm('Izinkan Website Untuk Memberikan Notifikasi!'))
              {
                  Notification.requestPermission().then(function (status) {
                      if (status === 'denied') {
                          alert('Demi Maksimalnya Website, Mohon Untuk Memberikan Izin Notifikasi!')

                      } else if (status === 'granted') {

                      }
                  });
              }
              else
              {
                  alert('Demi Maksimalnya Website, Mohon Untuk Memberikan Izin Notifikasi!')
              }
          }
        }
    },
    created() {
        // this.setAlertNotification()
        this.getUser()

        Echo.channel('limit-changed.' + this.user_id)
            .listen('LimitChangeEvent', (e) => {

                Notification.requestPermission().then(function (status) {

                    if (status === 'denied') {
                        alert('Demi Maksimalnya Website, Mohon Untuk Memberikan Izin Notifikasi!')
                        // this.setAlertNotification()

                    } else if (status === 'granted') {

                        let notification = new Notification('Persediaan Baru!', {
                            body: e['message'],
                            icon: 'https://beliayam.com/img/favicon.png',
                            tag: new Date() // msg-id
                        });

                        notification.onclick = function(event) {
                            event.preventDefault(); // prevent the browser from focusing the Notification's tab
                            window.open('/stock/opname', '_blank');
                        }
                    }
                });
            });

        Echo.channel('stock-request.' + this.user_id)
            .listen('StockRequestEvent', (e) => {

                Notification.requestPermission().then(function (status) {
                    if (status === 'denied') {
                        alert('Demi Maksimalnya Website, Mohon Untuk Memberikan Izin Notifikasi!')
                        // this.setAlertNotification()

                    } else if (status === 'granted') {

                        let notification = new Notification('Persediaan Baru!', {
                            body: e['message'],
                            icon: 'https://beliayam.com/img/favicon.png',
                            tag: new Date() // msg-id
                        });

                        notification.onclick = function(event) {
                            event.preventDefault(); // prevent the browser from focusing the Notification's tab
                            window.open('/stock/request-stock', '_blank');
                        }
                    }
                });
            });
    }
});
