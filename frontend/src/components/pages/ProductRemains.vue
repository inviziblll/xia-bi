<template>
  <v-layout row>
    <v-dialog
      v-model="dialogFilters"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      scrollable
    >
      <v-card tile>
        <v-toolbar card dark color="orange accent-4">
          <v-btn icon @click.native="dialogFilters = false" dark>
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Фильтры</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-layout row wrap>
            <v-flex xs12>
              <v-select
                label="Товары"
                autocomplete
                :items="products"
                item-text="name"
                item-value="id"
                v-model="search.product"
                multiple
              ></v-select>
            </v-flex>
            <v-flex xs12>
              <v-select
                label="Склады"
                autocomplete
                :items="warehouses"
                item-text="name"
                item-value="id"
                v-model="search.warehouse"
                multiple
              ></v-select>
            </v-flex>
            <v-flex xs12>
              <v-select
                label="Операции"
                autocomplete
                :items="operations"
                item-text="name"
                item-value="id"
                v-model="search.operation"
                multiple
              ></v-select>
            </v-flex>
            <v-flex xs6>
              <date-picker v-model="search.date_from" label="Дата с"></date-picker>
            </v-flex>
            <v-flex xs6>
              <date-picker v-model="search.date_to" label="Дата по"></date-picker>
            </v-flex>
          </v-layout>
        </v-card-text>

        <div style="flex: 1 1 auto;"></div>
      </v-card>
    </v-dialog>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Движение товаров</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить движение товара</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-select
                      label="Товар"
                      autocomplete
                      :items="products"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_id')"
                      data-vv-name="editedItem.product_id"
                      data-vv-as="Товар"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-select
                      label="Склад"
                      autocomplete
                      :items="warehouses"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.warehouse_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.warehouse_id')"
                      data-vv-name="editedItem.warehouse_id"
                      data-vv-as="Склад"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-select
                      label="Операция"
                      autocomplete
                      :items="operations"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.operation_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.operation_id')"
                      data-vv-name="editedItem.operation_id"
                      data-vv-as="Операция"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-menu
                      ref="menuDateFrom"
                      lazy
                      :close-on-content-click="false"
                      v-model="menu.date"
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
                        v-model="dateFormat.date"
                        prepend-icon="event"
                        readonly
                        v-validate="'required'"
                        :error-messages="errors.collect('editedItem.date')"
                        data-vv-name="editedItem.date"
                        data-vv-as="Дата смены"
                        required
                      ></v-text-field>
                      <v-date-picker
                        locale="ru-ru"
                        v-model="editedItem.date"
                        no-title scrollable
                        :first-day-of-week="1">
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu.date = false">Закрыть</v-btn>
                        <v-btn flat color="primary" @click="$refs.menuDateFrom.save(editedItem.date)">Выбрать</v-btn>
                      </v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Количество"
                      v-model="editedItem.count"
                      v-validate="'required|numeric'"
                      :error-messages="errors.collect('editedItem.count')"
                      data-vv-name="editedItem.count"
                      data-vv-as="Количество"
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
        <v-icon @click="dialogFilters = true" style="cursor: pointer">filter_list</v-icon>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="productRemains"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ (props.item.product)? props.item.product.name : ''}}</td>
          <td>{{ (props.item.warehouse)? props.item.warehouse.name : ''}}</td>
          <td>{{ (props.item.operation)? props.item.operation.name : ''}}</td>
          <td>{{ props.item.date | date }}</td>
          <td>{{ props.item.count }}</td>
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
        <!--<template slot="pageText" slot-scope="item">-->
          <!--Показано {{item.pageStart}} - {{item.pageStop}}, всего записей {{item.itemsLength}}-->
        <!--</template>-->
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          По Вашему запросу "{{ search }}" ничего не найдено.
        </v-alert>
      </v-data-table>
    </v-flex>
  </v-layout>
</template>

<script>
  import * as type from '@/vuex/types';
  import DatePicker from '@/components/common/DataPicker';

  export default {
    name: 'ProductRemains',
    created(){
      this.$store.dispatch(type.GET_PRODUCTS);
      this.$store.dispatch(type.GET_OPERATIONS);
      this.$store.dispatch(type.GET_WAREHOUSES);
      this.$store.dispatch(type.GET_PRODUCT_REMAINS, {page: 1, search:''});
    },
    data () {
      return {
        dialog: false,
        dialogFilters: false,
        page: 1,
        menu: {
          date: false,
        },
        dateFormat:{
          date: null,
        },
        search: {
          product: [],
          warehouse:[],
          operation:[],
          date_from: null,
          date_to: null
        },
        editedIndex: -1,
        editedItem: {
          warehouse_id:null,
          product_id:null,
          operation_id:null,
          date:null,
          count:null
        },
        defaultItem:{
          warehouse_id:null,
          product_id:null,
          operation_id:null,
          date:null,
          count:null
        },
        headers: [
          {
            text: 'Товар',
            align: 'left',
            value: 'product.name'
          },
          {
            text: 'Склад',
            align: 'left',
            value: 'warehouse.name'
          },
          {
            text: 'Операция',
            align: 'left',
            value: 'operation.name'
          },
          {
            text: 'Дата',
            align: 'left',
            value: 'date'
          },
          {
            text: 'Количество',
            align: 'left',
            value: 'count'
          },
          {
            text: 'Действия',
            align:'center',
            sortable: false
          }
        ],
      }
    },
    components:{DatePicker},
    watch:{
      "editedItem.date"(val) {
        if(val != null)
          this.dateFormat.date = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat.date = null
      },
      page(val){
        this.$store.dispatch(type.GET_PRODUCT_REMAINS, {page: val, search:this.search});
      },
      "search":{
        handler(val){
          this.page = 1;
          this.$store.dispatch(type.GET_PRODUCT_REMAINS, {page: 1, search:this.search});
        },
        deep: true
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить движение товара' : 'Редактировать движение товара'
      },
      products(){
        return this.$store.state.products;
      },
      operations(){
        return this.$store.state.operations;
      },
      warehouses(){
        return this.$store.state.warehouses;
      },
      productRemains(){
        return this.$store.state.productRemains;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(type.GET_PRODUCT_REMAIN, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_PRODUCT_REMAIN, itemId);
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
              this.$store.dispatch(type.UPDATE_PRODUCT_REMAIN, this.editedItem);
            } else {
              this.$store.dispatch(type.ADD_PRODUCT_REMAIN, this.editedItem)
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
