<template>
  <v-layout wrap row>
    <v-flex xs12>
      <v-layout row>
        <v-flex xs7>
          <v-select
            :items="grids"
            v-model="SelectPivot"
            item-text="title"
            item-value="id"
            label="Select"
            return-object
            single-line
            append-icon="delete"
            :append-icon-cb="remove"
          >
            <template slot="selection" slot-scope="data">
              {{ data.item.title }}{{(data.item.user) ? ' - ' + data.item.user.name: ''}}
            </template>
            <template slot="item" slot-scope="data">
              {{ data.item.title }}{{(data.item.user) ? ' - ' + data.item.user.name: ''}}
            </template>
          </v-select>
        </v-flex>
        <v-flex xs2>
          <v-btn color="success" @click.stop="sharePivot = true" v-if="!SelectPivot.user">Поделиться</v-btn>
          <v-dialog v-model="sharePivot" max-width="500px">
            <v-card>
              <v-card-title>
                Выберите пользователя
              </v-card-title>
              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-select
                        :items="users"
                        v-model="shareUser"
                        item-text="name"
                        item-value="id"
                        label="Пользователи"
                      ></v-select>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-btn color="primary" flat @click.stop="sharePivot=false">Закрыть</v-btn>
                <v-btn color="primary" flat @click="sharePivotUser()">Сохранить</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-flex>
        <v-flex offset-xs1 xs2>
          <v-btn color="success" @click.stop="addPivot = true">Создать отчет</v-btn>
          <v-dialog v-model="addPivot" max-width="500px">
            <v-card>
              <v-card-title>
                Создать отчет
              </v-card-title>
              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-text-field
                        label="Назавние отчета"
                        v-model="dataPivot.title"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-select
                        :items="cubes"
                        v-model="dataPivot.cube"
                        item-text="text"
                        item-value="text"
                        label="Куб"
                      ></v-select>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-btn color="primary" flat @click.stop="addPivot=false">Закрыть</v-btn>
                <v-btn color="primary" flat @click="SaveTable">Сохранить</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-flex>
      </v-layout>
    </v-flex>
    <v-flex xs12>
      <PivotGrid v-if="grids.length != 0" :options="SelectPivot.data" :cube="SelectPivot.cube" @saveData="saveData"/>
    </v-flex>
  </v-layout>
</template>
<script>
  import * as type from '@/vuex/types'
  import PivotGrid from '../widgets/PivotGrid'
  export default {
    name: "Analytics",
    created(){
      this.$store.dispatch(type.GET_REPORTS);
      this.$store.dispatch(type.GET_REPORTS_SHARE);
      this.$store.dispatch(type.GET_USERS);
    },
    mounted(){
    },
    data () {
      return {
        cubes:[
          {text: 'Чеки'},
          {text: 'Кросс-Чеки'}
        ],
        addPivot: false,
        sharePivot: false,
        dataPivot: {
          id: null,
          title:null,
          cube:null,
          data: '[]'
        },
        dataPivotDefault: {
          id: null,
          title:null,
          cube:null,
          data: '[]'
        },
        SelectPivot:{},
        shareUser:null,
      }
    },
    components:{
      PivotGrid
    },
    computed:{
      users(){
        return this.$store.state.users;
        console.log(3333)
      },
      grids(){
        if(this.$store.getters.getPivotData.length > 0){
          console.log('this.$store.getters.getPivotData[0] ',this.$store.getters.getPivotData[0])
          this.SelectPivot = this.$store.getters.getPivotData[0];
        }
        return this.$store.getters.getPivotData;
      }
    },
    methods:{
      remove(){
        let isRem = confirm('Вы уверены что хотите удалить запись?');
        if(isRem){
          if(this.SelectPivot.user){
            this.$store.dispatch(type.REMOVE_SHARE_REPORT,this.SelectPivot.idShare);
          }else{
            this.$store.dispatch(type.REMOVE_REPORT,this.SelectPivot.id);
          }
        }
      },
      saveData(option){
        if(!this.SelectPivot.user)
          this.$store.dispatch(type.UPDATE_REPORT, Object.assign({}, this.SelectPivot, {data: JSON.stringify(option)}));
      },
      SaveTable(){
        this.$store.dispatch(type.ADD_REPORT, this.dataPivot).then(
          result => {
            this.dataPivot = Object.assign({}, this.dataPivotDefault);
            this.addPivot = false
          }
        );
      },
      sharePivotUser(){
        this.$store.dispatch(type.SHARE_REPORT, {user_from: this.shareUser, report_id: this.SelectPivot.id}).then(
          result => {
            this.shareUser = null;
            this.sharePivot = false
          }
        );
      }
    }
  }
</script>
