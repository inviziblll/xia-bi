<template>


  <v-layout row wrap v-resize="onResize">
    <v-spacer></v-spacer>
    <v-flex xs6 mx-auto>
      <v-card-text class="black--text pt-0">Xiaomi BI — это набор средств бизнес-аналитики для анализа данных и
        предоставления ценной информации.
        Информационные панели Xiaomi BI — это единый центр с обновлением данных в режиме реального времени,
        доступный на всех устройствах, в котором бизнес-пользователи получают полное представление о наиболее важных
        метриках.
        Пользователи могут исследовать данные на информационных панелях одним щелчком, используя интуитивные
        инструменты, упрощающие поиск ответов.
      </v-card-text>
    </v-flex>
    <v-spacer></v-spacer>
    <v-flex xs6>
      <pie-graph :datasets="divisiopienmonthreport" :labelpie="labelpie"></pie-graph>
    </v-flex>
    <v-spacer></v-spacer>

    <v-flex xs12>
      <line-graph ref="lineChart" :datasets="divisionmonthreport" :height="500" :label="label"></line-graph>

    </v-flex>
  </v-layout>

</template>

<script>

  import LineGraph from '../widgets/LineChart';
  import PieGraph from '../widgets/PieChart';
  import {GET_DIVISION_MONTH_REPORT} from '@/vuex/types';
  import {GET_DIVISION_PIE_MONTH_REPORT} from '@/vuex/types';

  export default {
    name: 'home',
    data() {
        return {
          dataMonth: null
        }
    },
    created() {
      this.$store.dispatch(GET_DIVISION_MONTH_REPORT);
      this.$store.dispatch(GET_DIVISION_PIE_MONTH_REPORT);
    },
    components: {
      LineGraph,
      PieGraph
    },
    mounted () {
      this.onResize()
    },
    methods: {
      onResize () {
        // console.log(this.$refs.lineChart)
        // this.$refs.lineChart.showchart()
        this.$refs.lineChart.showchart()
      }
    },
    computed: {
      label() {
        let data = this.$store.state.divisionMonthReports;
        return data.map(function (value) {
          return value.DivisionName

        })
      },
      labelpie() {
        let data = this.$store.state.divisionPieMonthReports;
        return data.map(function (value) {
          return value.DivisionName

        })
      },
      divisionmonthreport() {
        let data = this.$store.state.divisionMonthReports;
        let datanew = data.map(function (value) {
          return value.Quantity

        })
        let datanew2 = data.map(function (value) {
          return value.Amount

        })


        return [
          {
            data: datanew,
            label: 'Количество',
            backgroundColor: '#fc9546',
            type: 'bar',
            fill: false,
            yAxisID: 'y-1',
          },
          {

            yAxisID: 'y-2',
            data: datanew2,
            label: 'Стоимость',
            fill: false,
            type: 'bar',
            backgroundColor: '#e1b799',
          }
        ]

      },

      // colorgenerate(){
      //   return ().length
      // },
      divisiopienmonthreport() {
        let data = this.$store.state.divisionPieMonthReports;
        let datanew = data.map(function (value) {
          return value.Amount
        });
        return [
          {
            data: datanew,
            label: 'Amount',
            backgroundColor: ['#9f4f3e', '#D0E1AA', '#E18BAB', '#E1A00E', '#ABA3FC', '#FC9298', '#AEE1C1'],
            fill: true,
          }
        ]

      }
    }
  }
</script>
