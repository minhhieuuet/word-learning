import { Line, mixins } from "vue-chartjs";
import rf from './../../../requests/RequestFactory';

export default {
  extends: Line,
  props: ["data", "options"],
  data() {
    return {
      datasets: [
        {
          label: 'Từ mới đã thêm',
          backgroundColor: '#7ac70cdb',
          data: [10, 19, 20, 40, 19, 25, 10],
        }
      ]
    }
  },
  mounted() {
    rf.getRequest('UserRequest').getNewWordStatistics().then(res => {
      this.datasets[0].data = res;
      this.renderChart({
        labels: ['Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy', 'Chủ nhật'],
        datasets: this.datasets
      }, {responsive: true, maintainAspectRatio: false, scaleFontColor: "#FFFFFF"});
    })
  }
};