import { Doughnut, mixins } from "vue-chartjs";
import rf from './../../../requests/RequestFactory';

export default {
  extends: Doughnut,
  data() {
    return {
            chartOptions: {
                hoverBorderWidth: 20,
                weight: 2,

            },
            chartData: {
                hoverBackgroundColor: "red",
                hoverBorderWidth: 10,
                labels: ["Thành thạo", "Chưa học", "Đang học"],
                datasets: [{
                    label: "Data One",
                    backgroundColor: ["#7ac70c", "#e53938", "#ffcc00"],
                    data: [0, 0, 0]
                }]
            },
    }
  },
  mounted() {
    rf.getRequest('UserRequest').getStatistics().then(res => {
      this.chartData.datasets = [{
              label: "Data One",
              backgroundColor: ["#7ac70c", "#e53938", "#ffcc00"],
              data: [res.word_count.done, res.word_count.new, res.word_count.learning]
      }];
      this.renderChart(this.chartData, {
        borderWidth: "10px",
        hoverBackgroundColor: "red",
        hoverBorderWidth: "10px",
        responsive: true, 
        scaleFontColor: "white"
      });
  })

  }
};