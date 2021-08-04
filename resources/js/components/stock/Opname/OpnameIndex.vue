<template>
  <div class="wrapper">
<!--      <Header></Header>-->

      <div class="row">
          <div class="col-md-12">
              <div class="card card-default">
                  <div class="card-header">
                      <div class="row">
                          <p class="m-0 p-4"><i class="fas fa-box"></i> Stock Keseluruhan</p>
                      </div>
                  </div>
                  <div class="text-right p-2 m-0">

                  </div>
                  <div class="card-body">

                      <div class="table-responsive">
                          <table class="table table-border" id="table-stock">
                              <thead>
                                  <tr class="text-center">
                                      <th>No</th>
                                      <th>SKU</th>
                                      <th>Nama Produk</th>
                                      <th>Berat Satuan</th>
                                      <th>Total Produk</th>
                                      <th>Total Karung</th>
                                      <th>Total Berat Karung</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr class="text-center" v-for="(stock, index) in stocks" :key="index">
                                      <td> {{ index + 1 }} </td>
                                      <td> {{ stock['product']['sku'] }} </td>
                                      <td class="text-left"> {{ stock['product']['name'] }}</td>
                                      <td> {{ stock['product']['weight'] }}</td>
                                      <td> {{ stock['total'] }}</td>
                                      <td> {{ stock['total_of_sack'] }}</td>
                                      <td> {{ stock['total_weights'] }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>

                  </div>
                  <!-- /.card-body -->
              </div>
          </div>
          <div class="col-md-6">
              <div class="card card-default">
                  <div class="card-header">
                      <div class="row">
                          <p class="m-0 p-4"><i class="fas fa-box"></i> Stock Terbaru DiUpload</p>
                      </div>
                  </div>
                  <div class="text-right p-2 m-0">

                  </div>
                  <div class="card-body">

                      <div class="table-responsive">
                          <table class="table table-border" id="table-recenntly-added-stock">
                              <thead>
                              <tr class="text-center">
                                  <th>No</th>
                                  <th>Jumlah</th>
                                  <th>Jumlah Karung</th>
                                  <th>Jumlah Berat Karung</th>
                                  <th>Tanggal</th>
                                  <th>PJ</th>
                                  <th>Detail</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr class="text-center" v-for="(product, index) in recently" :key="index">
                                  <td> {{ index + 1 }} </td>
                                  <td> {{ product['total_stock'] }} </td>
                                  <td> {{ product['total_of_sack'] }}</td>
                                  <td> {{ product['total_weights'] }}</td>
                                  <td> {{ product['date'] }}</td>
                                  <td> {{ product['pj'] }}</td>
                                  <td @click="openDetails(product['id'])">
                                      <button type="button" class="btn btn-outline-info rounded-circle">
                                          <i class="fad fa-info-square"></i>
                                      </button>
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </div>

                  </div>
                  <!-- /.card-body -->
              </div>
          </div>
          <div class="col-md-6">
              <div class="card card-default">
                  <div class="card-header">
                      <div class="row">
                          <p class="m-0 p-4"><i class="fas fa-box"></i> Stock Dibawah Ambang Batas</p>
                      </div>
                  </div>
                  <div class="text-right p-2 m-0">

                  </div>
                  <div class="card-body">

                      <div class="table-responsive">
                          <table class="table table-border" id="table-limits">
                              <thead>
                                  <tr class="text-center">
                                      <th>No</th>
                                      <th>Nama Produk</th>
                                      <th>Total Produk</th>
                                      <th>Status Batas</th>
                                      <th>Batas Min.</th>
                                      <th>Batas Maks.</th>
                                      <th>Total Karung</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr class="text-center" v-for="(product, index) in limits" :key="index">
                                      <td> {{ index + 1 }} </td>
                                      <td> {{ product['product']['name'] }} </td>
                                      <td> {{ product['stock'] | checkEmpty('total') }}</td>
                                      <td :inner-html.prop="product['limit_status'] | checkStatus"> </td>
                                      <td> {{ product['stock_min'] }}</td>
                                      <td> {{ product['stock_max'] }}</td>
                                      <td> {{ product['stock'] | checkEmpty('total_of_sack') }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>

                  </div>
                  <!-- /.card-body -->
              </div>
          </div>
      </div>

      <div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
              <div class="modal-content" v-if="stockSelected.length > 0">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <header>
                          <h5 class="modal-title text-center" id="staticBackdropLabel">Data Stock</h5>
                          <h6>Tanggal: <b>{{ stockSelected[0].date | formatDate }}</b></h6>
                          <h6>Penanggung Jawab: <b>{{ stockSelected[0]['pj']}}</b></h6>
                      </header>
                      <div class="table-responsive">
                          <table class="table table-border table-hover">
                              <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SKU</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total Karung</th>
                                    <th>Total Berat (Kg)</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(product, index) in stockSelected[0]['stock_opname_items']" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ product['product'][0]['sku'] }}</td>
                                    <td>{{ product['product'][0]['name'] }}</td>
                                    <td>{{ product['contents'] }}</td>
                                    <td>{{ product['total_of_sack'] }}</td>
                                    <td>{{ product['total_weight'] }}</td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td colspan="3" class="text-center">Jumlah</td>
                                    <td>{{ stockSelected[0]['total_stock'] }}</td>
                                    <td>{{ stockSelected[0]['total_of_sack'] }}</td>
                                    <td>{{ stockSelected[0]['total_weights'] }}</td>
                                </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle"></i> Tutup</button>
                      <button type="button" class="btn btn-success"><i class="fad fa-print"> </i> Cetak</button>
                  </div>
              </div>
          </div>
      </div>

  </div>
</template>

<script>
import Header from './Header/Header.vue'
import moment from 'moment'
moment.locale('id');

export default {
    name: "OpnameIndex",
    props: ['recently', 'stocks', 'limits'],
    components: {
        Header,
        moment
    },
    data(){
        return {
            stockSelected: []
        }
    },
    methods: {
        openDetails(id){

            let data = this.recently.filter( (value) => {
                return value['id'] === id
            })

            this.stockSelected = data
            $("#modal-detail").modal('show')

        }
    },
    filters: {
        formatDate(date){
            return moment(date).format('Do MMMM YYYY, HH:mm');
        },
        checkStatus(status){
            switch (status) {
                case true:
                    return '<span class="badge badge-success">Wajar</span>';
                default:
                    return '<span class="badge badge-danger">Dibawah Batas</span>';
            }
        },
        checkEmpty(value, type){

            if (Object.keys(value).length){

                return value[type]

            }

            if (value.length > 0){

                return value[type]

            }

            return 0

        }
    }
};
</script>

<style>
</style>
