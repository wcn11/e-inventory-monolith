<template>
  <div class="card mb-3 col-lg-4" style="max-width: 540px">
    <div class="row no-gutters">
      <div
        class="col-md-4 icon-header text-center text-success"
        style="font-size: 100px"
      >
        <i class="fad fa-boxes-alt p-5"></i>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title w-100 mb-5">Total Stock Opname</h5>
          <div class="row mb-5">
            <div class="col-md-4">
              <h3>41</h3>
              <div class="text-muted">Total</div>
            </div>
            <div class="col-md-4">
              <h3>12</h3>
              <div class="text-muted">Ambang Maks.</div>
            </div>
            <div class="col-md-4">
              <h3>22</h3>
              <div class="text-muted">Ambang Min.</div>
            </div>
          </div>
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
import PieChart from "../../../../Chart/PieChart.vue";
export default {
  name: "HeaderCardOne",
  components: {
    PieChart,
  },
};
</script>

<style scoped>
.icon-header {
  font-size: 100px;
}
</style>