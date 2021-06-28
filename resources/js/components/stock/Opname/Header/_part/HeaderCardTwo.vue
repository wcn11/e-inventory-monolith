<template>
  <div class="card mb-3 col-lg-4" style="max-width: 540px">
    <div class="row no-gutters">
      <div
        class="col-md-4 icon-header text-center text-danger"
        style="font-size: 100px"
      >
        <i class="fad fa-pallet-alt p-5"></i>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title w-100">Total Stock Opname</h5>
          <PieChart />
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