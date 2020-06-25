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
                label="Магазины"
                autocomplete
                :items="shops"
                item-text="name"
                item-value="id"
                v-model="search.shops"
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
        <v-subheader class="title">Посещаемость</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать посещаемость</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
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
        :items="visitLogs"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.date | date }}</td>
          <td>{{ (props.item.shop) ? props.item.shop.name:'' }}</td>
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
    name: 'VisitLogs',
    created(){
      this.$store.dispatch(type.GET_VISIT_LOGS, {page: 1, search:''});
      this.$store.dispatch(type.GET_SHOPS);
    },
    data() {
      return {
        dialog: false,
        dialogFilters: false,
        page: 1,
        menu: {
          date: false,
        },
        dateFormat:{
          date: '',
        },
        search: {
          shops: [],
          date_from: null,
          date_to: null
        },
        editedIndex: -1,
        editedItem: {
          count: null,
          date: null,
          shop_id: null
        },
        defaultItem: {
          count: null,
          date: null,
          shop_id: null
        },
        headers: [
          {
            text: 'Дата',
            align: 'left',
            value: 'date',
            sortable: false
          },
          {
            text: 'Магазин',
            align: 'left',
            value: 'shop.name',
            sortable: false
          },
          {
            text: 'Количество',
            align: 'left',
            value: 'count',
            sortable: false
          },
          {
            text: 'Действия',
            align: 'center',
            sortable: false
          }
        ]
      }
    },
    components:{DatePicker},
    watch:{
      "editedItem.date"(val) {
        if(val != null)
          this.dateFormat.date = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat.date = null;
      },
      page(val){
        this.$store.dispatch(type.GET_VISIT_LOGS, {page: val, search:this.search});
      },
      "search":{
        handler(val){
          this.page = 1;
          this.$store.dispatch(type.GET_VISIT_LOGS, {page: 1, search:this.search});
        },
        deep: true
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Создать посещаемость' : 'Редактировать посещаемость'
      },
      shops(){
        return this.$store.state.shops
      },
      visitLogs(){
        return this.$store.state.visitLogs
      },
      pageController(){
        return this.$store.state.pageController
      },
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(type.GET_VISIT_LOG, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_VISIT_LOG, itemId)
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
              this.$store.dispatch(type.UPDATE_VISIT_LOG, this.editedItem)
            } else {
              this.$store.dispatch(type.ADD_VISIT_LOG, this.editedItem)
            }
            this.close()
          }
        })
      }
    }
  }
</script>
