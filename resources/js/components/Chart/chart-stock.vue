<template>
    <!-- /.row -->
    <div class="row">

        <div class="col-md-2">
            <div class="info-box bg-gradient-success bar-stock">
                <span class="info-box-icon"><i class="fas fa-sort-amount-up-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Stock terkini</span>
                    <span class="info-box-number">{{ data }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cloud-upload-alt"></i> Upload Data</h3>
                </div>
                <div class="card-body quick-menu-upload">
                    <div class="row">
                        <div class="col-md-3">
                            <a type="button" class="btn btn-info m-1" href="/stock/trip">
                                <i class="fas fa-upload"></i> Upload
                            </a>
                        </div>
                        <div class="col-md-9" style="border: 2px solid black; border-radius: 1rem;">
                            <div class="row">
                                <div class="col-md-4">
                                    <a type="button" class="btn btn-info m-1" href="/stock/berita-acara-pdf">
                                        <i class="fas fa-file-pdf"></i> Download Berita Acara .pdf
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a type="button" class="btn btn-info m-1" href="/stock/berita-acara-word">
                                        <i class="fas fa-file-word"></i> Download Berita Acara .docx
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a type="button" class="btn btn-info m-1" href="/stock/berita-acara-example">
                                        <i class="fas fa-file-check"></i> Download Contoh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cloud-upload-alt"></i> Cari Berdasarkan Tanggal:</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="from">Dari Tanggal:</label>
                            <input type="date" name="from" v-model="from" id="from" class="form-control">
                        </div>
                        <div class="col">
                            <label for="to">Sampai Tanggal:</label>
                            <input type="date" name="to" v-model="to" id="to" class="form-control">
                        </div>
                        <div class="col">
                            <div class="offset-md-2 justify-content-center">
                                <button class="btn btn-success mx-auto btn-search" id="search" @click="searchData()" data-toggle="tooltip" data-placement="top" title="Cari Data Berdasarkan Tanggal"><i class="fab fa-searchengin "></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title text-center">Statistik Stock</h3>
                </div>
                <div class="card-body">
                    <canvas id="planet-chart"></canvas>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</template>

<script>
import chart from 'chart.js'
import moment from 'moment'
import Swal from "sweetalert2";
moment.locale('id');

export default {
    name: "chart-stock",
    props: [
        'data'
    ],
    components: {
        chart,
        Swal
    },
    data(){
        return {
            labels: [],
            stocks: [],
            from: "",
            to: ""
        }
    },
    methods: {
        filterChar(array, key) {
            return array.map(function(item) { return item[key]; });
        },
        openAlert(icon = 'success', message){
            Swal.fire({
                position: 'center',
                icon: icon,
                title: message,
                showConfirmButton: true
            })
        },
        searchData(){
            if (this.from === "" || this.to === ""){
                this.openAlert('warning', 'Harap Isi Tanggal')
                return
            }

            axios.get(`/api/stock/chart?from=${this.from}&to=${this.to}`)
                .then(res => {
                    if (res.data.success){

                        this.labels =  res.data.data.map(function(item) { return moment(item['created_at']).format('Do MMMM YYYY')})
                        this.stocks = res.data.data.map(function(item) { return item['total_stock']; });

                        this.setChart()
                    }
                }).
                catch(err => {
                    this.openAlert('error', 'Terjadi Error, Muat Ulang Halamn!')
                })
        },
        async getData(){
            await axios.get(`/api/stock/chart?from=${moment().subtract(10, 'days').format('YYYY-MM-DD HH:mm:ss')}&to=${moment().format('YYYY-MM-DD HH:mm:ss')}`)
                .then(res => {
                    if (res.data.success){

                        let label =  res.data.data.map(function(item) { return moment(item['created_at']).format('Do MMMM YYYY')})
                        let data = res.data.data.map(function(item) { return item['total_stock']; });

                        this.labels = label
                        this.stocks = data
                    }
                }).
                catch(err => {
                    this.openAlert('error', 'Terjadi Error, Muat Ulang Halamn!')
                })
        },

        setChart(){
                let ctx = $("#planet-chart")[0];
                let myLineChart = new Chart(ctx, {
                    type: "line",
                    labels: this.labels,
                    data: {
                        datasets: [
                            {
                                data: this.stocks.map((total, index) => {
                                    return {
                                        x: moment(this.labels[index], 'D MMMM YYYY'),
                                        y: total
                                    }
                                }),
                                label: "Stock",
                                backgroundColor: "rgba(71, 183,132,.5)",
                                borderColor: "#47b784",
                                borderWidth: 3
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                        },
                        tooltip: {
                            enabled: true
                        },
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true
                                },
                                type: "time",
                                time: {
                                    unit: "day",
                                    displayFormats: {
                                        day: "D MMMM YYYY"
                                    },
                                    tooltipFormat: "D MMMM YYYY",
                                    stepSize: 1
                                },
                                ticks: {
                                    source: 'data',
                                    display: true,
                                    autoSkip: true,
                                    minRotation: 45,
                                },
                                position: "bottom",
                                distribution: 'series',
                            }],
                            yAxes: [{
                                ticks:
                                    {
                                        suggestedMin: 0,
                                        suggestedMax: 100 ,
                                        beginAtZero: false,
                                    }
                            }]
                        }
                    }
                });
        },

        date(date){
            return moment(date).format('DD-MM-yyyy, HH:mm');
        }
    },
    mounted: async function(){
        await this.getData()
        this.setChart()
    }
}
</script>

<style scoped>

</style>
