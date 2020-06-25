

<script>
  import {Bar} from 'vue-chartjs'
  import {GET_DIVISION_MONTH_REPORT} from '@/vuex/types';
  export default {
    extends: Bar,
    name: "lineChart",
    created(){
      // this.$store.dispatch(GET_DIVISION_MONTH_REPORT);
    },

    props: ['datasets','label'],

    mounted () {
      this.showchart();
    },
    methods:  {

      showchart() {
        this.renderChart({
          labels: this.label,//,
          // //this.datasets
          datasets: this.datasets

        }, {responsive: true, maintainAspectRatio: false,

          scales: {

            xAxes: [{
              stacked: false,

            }],
            yAxes: [{
              stacked: true,
              position: "left",
              id: "y-1",
              scaleLabel:{
                display: true,
                labelString: 'Штуки',
                fontColor: '#fc9546',
                //fontSize: 20,
              },
              ticks:{
                fontColor: '#fc9546',
              }
            }, {
              display: true,
              stacked: true,
              position: "right",
              id: "y-2",
              ticks:{
                fontColor: '#e1b799',
                callback: function (value, index, values) {
                  return value + " ₽";
                },

              }
            }]
          }


        })
      }
    },
    watch: {
      datasets(){
        this.showchart()
      }
    }
  }
</script>
