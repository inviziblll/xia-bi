<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Список смен магазинов</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать смену магазина</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
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
                      label="Дата смены"
                      v-model="dateFormat"
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
                      <v-btn flat color="primary" @click="menuDate = false">Закрыть</v-btn>
                      <v-btn flat color="primary" @click="$refs.menuDate.save(editedItem.date)">Выбрать</v-btn>
                    </v-date-picker>
                  </v-menu>
                  </v-flex>
                  <v-flex xs6>
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
                  <v-flex xs6>
                    <v-select
                      label="Сотрудник"
                      autocomplete
                      :items="users"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.user_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.user_id')"
                      data-vv-name="editedItem.user_id"
                      data-vv-as="Сотрудник"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Должность"
                      autocomplete
                      :items="roles"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.role_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.role_id')"
                      data-vv-name="editedItem.role_id"
                      data-vv-as="Должность"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Смена"
                      autocomplete
                      :items="shifts"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.shift_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.shift_id')"
                      data-vv-name="editedItem.shift_id"
                      data-vv-as="Смена"
                      required
                    ></v-select>
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
        :items="shopShifts"
        :search="search"
        :pagination.sync="pagination"
        :total-items="pagination.totalStaff"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.date | date }}</td>
          <td>{{ (props.item.shops)? props.item.shops.name : '' }}</td>
          <td>{{ (props.item.users)? props.item.users.name : '' }}</td>
          <td>{{ (props.item.roles)? props.item.roles.name : '' }}</td>
          <td>{{ (props.item.shifts)? props.item.shifts.name : '' }}</td>
          <td class="justify-center layout px-0">
            <v-btn icon class="mx-0" @click="editItem(props.item.id)">
              <v-icon color="primary">edit</v-icon>
            </v-btn>
            <v-btn icon class="mx-0" @click="deleteItem(props.item.id)">
              <v-icon color="pink">delete</v-icon>
            </v-btn>
          </td>
        </template>
        <template slot="pageText" slot-scope="item">
          Показано {{item.pageStart}} - {{item.pageStop}}, всего записей {{item.itemsLength}}
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
  import moment from 'moment';
  export default {
    name: 'ShopShifts',
    created(){
      // this.$store.dispatch(type.GET_SHOP_SHIFTS);
      this.$store.dispatch(type.GET_USERS);
      this.$store.dispatch(type.GET_SHOPS);
      this.$store.dispatch(type.GET_SHIFTS);
      this.$store.dispatch(type.GET_ROLES);
    },
    data() {
      return {
        dialog: false,
        menuDate: false,
        dateFormat: null,
        search: '',
        editedIndex: -1,
        editedItem: {
          id: null,
          user_id: null,
          role_id: null,
          shift_id: null,
          shop_id: null,
          date: null
        },
        defaultItem: {
          id: null,
          user_id: null,
          role_id: null,
          shift_id: null,
          shop_id: null,
          date: null
        },
        headers: [
          {
            text: 'Дата',
            align: 'left',
            value: 'date'
          },
          {
            text: 'Магазин',
            align: 'left',
            value: 'shops.name'
          },
          {
            text: 'Сотрудник',
            align: 'left',
            value: 'users.name'
          },
          {
            text: 'Должность',
            align: 'left',
            value: 'roles.name'
          },
          {
            text: 'Смена',
            align: 'left',
            value: 'shifts.name'
          },
          {
            text: 'Actions',
            align: 'center',
            value: 'name',
            sortable: false
          }
        ],
        pagination: {
          sortBy: 'shops.name',
          totalStaff: ''
        },
      }
    },
    watch:{
      "editedItem.date"(val) {
        if(val != null)
          this.dateFormat = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat = null
      },
      search: {
        handler () {
          this.getDataFromApi()
        },
        deep: true
      },
      pagination: {
        handler () {
          this.getDataFromApi()
        },
        deep: true
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Создать смену магазина' : 'Редактировать смену магазина'
      },
      users(){
        return this.$store.state.users
      },
      shops(){
        return this.$store.state.shops
      },
      roles(){
        return this.$store.state.roles
      },
      shifts(){
        return this.$store.state.shifts
      },
      shopShifts() {
        this.pagination.totalStaff = this.$store.state.shopShiftsPaginate.total
        return this.$store.state.shopShiftsPaginate.data;
      }
    },
    methods:{
      getDataFromApi(){
        const { sortBy, descending, page, rowsPerPage } = this.pagination
        const searchText = this.search
        this.$store.dispatch(type.GET_SHOP_SHIFT_PAGINATE, {sortBy, descending, page, rowsPerPage, searchText});
      },

      editItem (itemId) {
        this.$store.dispatch(type.GET_SHOP_SHIFT, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result, {date: moment(result.date).format('YYYY-MM-DD')});
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_SHOP_SHIFT, itemId)
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
              this.$store.dispatch(type.UPDATE_SHOP_SHIFT, this.editedItem)
            } else {
              this.$store.dispatch(type.ADD_SHOP_SHIFT, this.editedItem)
            }
            this.close()
          }
        })
      }
    }
  }
</script>
