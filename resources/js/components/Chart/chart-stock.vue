<template>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title text-center">Statistik Stock</h3>
                </div>
                <div class="card-body">
                    <canvas id="planet-chart"></canvas>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                    <!-- Statistik table -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Keluar Masuk Stock</h3>
                            <div class="card-tools">

                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <chart-stock-table></chart-stock-table>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</template>

<script>
import chart from 'chart.js'
import PlanetChart from './chart-stock'
import ChartStockTable from "./ChartStockTable";

export default {
    name: "chart-stock",
    components: {
        chart,
        PlanetChart,
        ChartStockTable
    },
    data(){
        return {
            planetChartData: PlanetChart
        }
    },
    mounted() {
        const ctx = document.getElementById('planet-chart');
        new Chart(ctx, this.planetChartData);
    }
}
</script>

<style scoped>

</style>
