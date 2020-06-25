
<template>

    <v-tabs grow show-arrows>
      <v-tab>
        Таблица
      </v-tab>
      <v-tab>
        График
      </v-tab>
      <v-tab-item ref="blockGrid">
        <DxPivotGrid ref="grid" :export="{ enabled: true, fileName: cube}" :allowFiltering="true" :dataSource="dataSource" :width="'100%'" :onContentReady="optionChanged"/>
      </v-tab-item>
      <v-tab-item style="width: 100%; display: block" ref="blockChart">
        <dx-chart ref="chart" :adaptiveLayout="{height:0}" :commonSeriesSettings="{type: 'bar'}" :legend='{position: "outside",horizontalAlignment: "center", verticalAlignment: "bottom"}'  :size="{width:'100%', height:700}"/>
      </v-tab-item>
    </v-tabs>
</template>

<script>
  import 'devextreme/dist/css/dx.common.css';
  import 'devextreme/dist/css/dx.light.compact.css';
  import Vue from 'vue';

  import ruMessages from 'devextreme/localization/messages/ru.json';
  import { locale, loadMessages } from 'devextreme/localization';
  loadMessages(ruMessages);
  locale(navigator.language || navigator.browserLanguage);

  import { DxPivotGrid, DxChart } from 'devextreme-vue';

  export default {
    name: 'PivotGrid',
    components: { DxPivotGrid, DxChart },
    mounted(){
      let grid = this.$refs.grid.instance;
      let chart = this.$refs.chart.instance;
      let blockChart = this.$refs.blockChart;

      grid.bindChart(chart, {
        dataFieldsDisplayMode: "splitPanes",
        alternateDataFields: false
      });
      if(this.options !== null){
        this.dataSource = Object.assign({}, this.dataSource, {fields: this.options});
      }
      setTimeout(function () {
        blockChart.$el.style.display = "none";
      }, 500);
    },
    props:{
      options:{
        type: Array,
        default: null
      },
      cube:{
        type: String,
        default: null
      },
    },

    computed:{
      dataSource:{
        get(){
          return {
            store: {
              type: "xmla",
              url: "http://92.39.139.7:81/olap/msmdpump.dll",
              catalog: "Xiaomi-BI_Prod",
              cube: this.cube
            },
            fields: this.options
          };
        },
        set(){
        }
      }
    },
    watch: {
      dataSource: function () {
        let blockChart = this.$refs.blockChart;
        let blockGrid = this.$refs.blockGrid;
        let grid = false;

        if(blockGrid.$el.style.display != 'none'){
          blockChart.$el.style.display = "block";
        }else{
          blockGrid.$el.style.display = "block";
          grid = true;
        }
        setTimeout(function () {
          if(grid){
            blockGrid.$el.style.display = "none";
          }else{
            blockChart.$el.style.display = "none";
          }
        }, 500);
      }
      // options: function(newOption, oldOption) {
      //   let blockChart = this.$refs.blockChart;
      //   let blockGrid = this.$refs.blockGrid;
      //   let grid = false;
      //
      //   if(blockGrid.$el.style.display != 'none'){
      //     blockChart.$el.style.display = "block";
      //   }else{
      //     blockGrid.$el.style.display = "block";
      //     grid = true;
      //   }
      //   this.dataSource = Object.assign({}, this.dataSource, {fields: newOption});
      //   setTimeout(function () {
      //     if(grid){
      //       blockGrid.$el.style.display = "none";
      //     }else{
      //       blockChart.$el.style.display = "none";
      //     }

      //   }, 500);
      // }
    },
    methods:{
      optionChanged(e){
        let option = this.$refs.grid.instance.option();
        this.$emit('saveData',e.component.getDataSource().state().fields);
      }
    }
  }
</script>

<style scoped lang="scss">
  .widget{
    background-color: #ffffff;
    border-radius: 8px;
    padding: 8px;
  }
</style>
