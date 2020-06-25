<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Грейды</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить грейд</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-select
                      label="Магазин"
                      autocomplete
                      :items="shops"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.shop_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.shop_id')"
                      data-vv-name="editedItem.shop_id"
                      data-vv-as="Магазин"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-menu
                      ref="menuDate"
                      lazy
                      :close-on-content-click="false"
                      v-model="menuDate"
                      transition="scale-transition"
                      offset-y
                      full-width
                      :nudge-right="40"
                      min-width="290px"
                      :return-value.sync="editedItem.date"
                    >
                      <v-text-field
                        slot="activator"
                        label="Дата"
                        v-model="dateFormat"
                        prepend-icon="event"
                        readonly
                        v-validate="'required'"
                        :error-messages="errors.collect('editedItem.date')"
                        data-vv-name="editedItem.date"
                        data-vv-as="Дата"
                        required
                      ></v-text-field>
                      <v-date-picker
                        locale="ru-ru"
                        v-model="editedItem.date"
                        no-title scrollable
                        :first-day-of-week="1">
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menuDate = false">Закрыть</v-btn>
                        <v-btn flat color="primary" @click="$refs.menuDate.save(editedItem.date)">Выбрать</v-btn>
                      </v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Бонус"
                      v-model="editedItem.tt_bonus"
                      v-validate="'required|numeric'"
                      :error-messages="errors.collect('editedItem.tt_bonus')"
                      data-vv-name="editedItem.tt_bonus"
                      data-vv-as="Бонус"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Индивидуальный"
                      v-model="editedItem.tt_seperate"
                      v-validate="'required|numeric'"
                      :error-messages="errors.collect('editedItem.tt_seperate')"
                      data-vv-name="editedItem.tt_seperate"
                      data-vv-as="Индивидуальный"
                      required
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click.native="close">Закрыть</v-btn>
              <v-btn color="blue darken-1" flat @click="save">Сохранить</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-spacer></v-spacer>
        <v-text-field
          append-icon="search"
          label="Поиск"
          single-line
          hide-details
          v-model="search"
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="shopGrades"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ (props.item.shop)? props.item.shop.name : ''}}</td>
          <td>{{ props.item.date | date }}</td>
          <td>{{ props.item.tt_bonus }}</td>
          <td>{{ props.item.tt_seperate }}</td>
          <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="editItem(props.item.id)">
              <v-icon color="primary">edit</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="deleteItem(props.item.id)">
              <v-icon color="pink">delete</v-icon>
            </v-btn>
          </td>
        </template>
        <template slot="footer">
          <td colspan="100%" style="text-align: right">
            <v-pagination :length="pageController.last_page" v-model="page" :total-visible="10"></v-pagination>
          </td>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          По Вашему запросу "{{ search }}" ничего не найдено.
        </v-alert>
      </v-data-table>
    </v-flex>
  </v-layout>
</template>

<script>
  import {GET_SHOP_GRADES, GET_SHOP_GRADE, ADD_SHOP_GRADE, UPDATE_SHOP_GRADE, REMOVE_SHOP_GRADE, GET_SHOPS} from '@/vuex/types';

  export default {
    name: 'ShopGrades',
    created(){
      this.$store.dispatch(GET_SHOPS);
      this.$store.dispatch(GET_SHOP_GRADES, 1);
    },
    data () {
      return {
        dialog: false,
        page: 1,
        menuDate: false,
        dateFormat: null,
        search: '',
        editedIndex: -1,
        editedItem: {
          shop_id: null,
          date:null,
          tt_bonus:null,
          tt_seperate:null
        },
        defaultItem:{
          shop_id: null,
          date:null,
          tt_bonus:null,
          tt_seperate:null
        },
        headers: [
          {
            text: 'Магазин',
            align: 'left',
            value: 'shop.name'
          },
          {
            text: 'Дата',
            align: 'left',
            value: 'date'
          },
          {
            text: 'Бонус',
            align: 'left',
            value: 'tt_bonus'
          },
          {
            text: 'Индивидуальный',
            align: 'left',
            value: 'tt_seperate'
          },
          {
            text: 'Действия',
            align:'center',
            sortable: false
          }
        ],
      }
    },
    watch:{
      "editedItem.date"(val) {
        if(val != null)
          this.dateFormat = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat = null
      },
      page(val){
        this.$store.dispatch(GET_SHOP_GRADES, val);
      },
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить грейд' : 'Редактировать грейд'
      },
      shops(){
        return this.$store.state.shops;
      },
      shopGrades(){
        return this.$store.state.shopGrades;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_SHOP_GRADE, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(REMOVE_SHOP_GRADE, itemId);
      },

      close () {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
          this.$nextTick(() => this.$validator.reset())
        }, 300)
      },

      save () {
        this.$validator.validateAll().then(result => {
          if (result) {
            if (this.editedIndex > -1) {
              this.$store.dispatch(UPDATE_SHOP_GRADE, this.editedItem);
            } else {
              this.$store.dispatch(ADD_SHOP_GRADE, this.editedItem)
            }
            this.close()
          }
        })
      }
    }
  }
</script>

<style scoped lang="scss">

</style>
