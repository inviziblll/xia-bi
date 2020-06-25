

<script>
  import {Doughnut} from 'vue-chartjs'
  import {GET_DIVISION_PIE_MONTH_REPORT} from '@/vuex/types';
  export default {
    extends: Doughnut,

    created(){
      // this.$store.dispatch(GET_DIVISION_MONTH_REPORT);
    },

    props: ['datasets','labelpie'],

    mounted() {
      this.showChart()
    },
    methods: {
      showChart() {
        this.renderChart({
            labels: this.labelpie,
            datasets: this.datasets
          },
          {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: true,
              position: "left",
              labels: {
                fontColor: "#333",
                fontSize: 20,
              }
            }

          })
      }
    },
    watch:{
      datasets(){
        this.showChart()
      }
    }
  }
</script>
