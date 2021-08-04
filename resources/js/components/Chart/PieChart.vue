
<script>
import { Pie } from "vue-chartjs";

export default {
  name: "PieChart",
  extends: Pie,
  data () {
    return {
      chartdata: {
        labels: ["Pie 1", "Pie 2", "Pie 3", "Pie 4", "Pie 5"],
        datasets: [
          {
            backgroundColor: [
              "#1E9600",
              "#99C802",
              "#FFF200",
              "#F89403",
              "#FF0000",
            ],
            data: [1, 2, 3, 4, 5],
          },
        ],
      },
      options: {
        responsive: true,
        legend: {
          display: true,
          position: "right",
        },
      },
    };
  },
  mounted() {
    this.renderChart(this.chartdata, this.options);
  },
};
</script>

<style>
</style>