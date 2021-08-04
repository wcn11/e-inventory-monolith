<template>
  <div class="card mb-3 col-lg-4" style="max-width: 540px">
    <div class="row no-gutters">
      <div class="col-md-4 icon-header text-center" style="font-size:100px;">
        <i class="fad fa-box-alt p-5"></i>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <PieChart/>
          <!-- <h5 class="card-title">Total Stock Opname</h5>
          <p class="card-text">
            This is a wider card with supporting text below as a natural lead-in
            to additional content. This content is a little bit longer.
          </p>
          <p class="card-text">
            <small class="text-muted">Terakhir Update 8 Juni 2021</small>
          </p> -->
        </div>
      </div>
    </div>
    <div class="card-footer bg-outline-light position-absolute" style="bottom: 0px;">
      <div class="card-text">
        <a href="#">Lihat Seluruh Data</a>
      </div>
    </div>
  </div>
</template>

<script>
import PieChart from "../../../../Chart/PieChart.vue"
export default {
  name: "HeaderCardThree",
  components: {
    PieChart
  }
};
</script>

<style scoped>
.icon-header {
  font-size: 100px;
}
</style>