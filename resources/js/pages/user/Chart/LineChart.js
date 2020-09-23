import { Line, mixins } from "vue-chartjs";
export default {
  extends: Line,
  props: ["data", "options"],
  mounted() {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object
    this.renderChart({
      labels: ['Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
      datasets: [
        {
          label: 'Từ mới đã thêm',
          backgroundColor: '#7ac70cdb',
          data: [10, 19, 20, 40, 19, 25, 10]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false, scaleFontColor: "#FFFFFF"});
  }
};