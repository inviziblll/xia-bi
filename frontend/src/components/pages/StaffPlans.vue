<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Список планновой загрузки</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать планновую загрузку</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs6>
                    <v-menu
                      ref="menuDateFrom"
                      lazy
                      :close-on-content-click="false"
                      v-model="menu.date_from"
                      transition="scale-transition"
                      offset-y
                      full-width
                      :nudge-right="40"
                      min-width="290px"
                      :return-value.sync="editedItem.date_from"
                    >
                      <v-text-field
                        slot="activator"
                        label="Дата c"
                        v-model="dateFormat.date_from"
                        prepend-icon="event"
                        readonly
                        v-validate="'required'"
                        :error-messages="errors.collect('editedItem.date_from')"
                        data-vv-name="editedItem.date_from"
                        data-vv-as="Дата смены"
                        required
                      ></v-text-field>
                      <v-date-picker
                        locale="ru-ru"
                        v-model="editedItem.date_from"
                        no-title scrollable
                        :first-day-of-week="1">
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu.date_from = false">Закрыть</v-btn>
                        <v-btn flat color="primary" @click="$refs.menuDateFrom.save(editedItem.date_from)">Выбрать</v-btn>
                      </v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs6>
                    <v-menu
                      ref="menuDateTo"
                      lazy
                      :close-on-content-click="false"
                      v-model="menu.date_to"
                      transition="scale-transition"
                      offset-y
                      full-width
                      :nudge-right="40"
                      min-width="290px"
                      :return-value.sync="editedItem.date_to"
                    >
                      <v-text-field
                        slot="activator"
                        label="Дата по"
                        v-model="dateFormat.date_to"
                        prepend-icon="event"
                        readonly
                        v-validate="'required'"
                        :error-messages="errors.collect('editedItem.date_to')"
                        data-vv-name="editedItem.date_to"
                        data-vv-as="Дата смены"
                        required
                      ></v-text-field>
                      <v-date-picker
                        locale="ru-ru"
                        v-model="editedItem.date_to"
                        no-title scrollable
                        :first-day-of-week="1">
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu.date_to = false">Закрыть</v-btn>
                        <v-btn flat color="primary" @click="$refs.menuDateTo.save(editedItem.date_to)">Выбрать</v-btn>
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
        :items="staffPlans"
        :pagination.sync="pagination"
        :total-items="pagination.totalStaff"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.date_from | date }}</td>
          <td>{{ props.item.date_to | date }}</td>
          <td>{{ (props.item.shops) ? props.item.shops.name:'' }}</td>
          <td>{{ (props.item.roles) ? props.item.roles.name:'' }}</td>
          <!--<td>{{ props.item.count }}</td>-->
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
  export default {
    name: 'StaffPlans',
    created(){
      // this.$store.dispatch(type.GET_ROLES);
      // this.$store.dispatch(type.GET_SHOPS);
      // this.$store.dispatch(type.GET_STAFF_PLANS);
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
            value: 'name'
          },
          {
            text: 'Сотрудник',
            align: 'left',
            value: 'shops.name'
          },
          {
            text: 'Должность',
            align: 'left',
            value: 'roles.name'
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
      "editedItem.date_from"(val) {
        if(val != null)
          this.dateFormat.date_from = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat.date_from = null;
      },
      "editedItem.date_to"(val) {
        if(val != null)
          this.dateFormat.date_to = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat.date_to = null;
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
        return this.editedIndex === -1 ? 'Создать смену' : 'Редактировать смену'
      },
      staffPlans() {
        this.pagination.totalStaff = this.$store.state.staffPlansPaginate.total
        return this.$store.state.staffPlansPaginate.data;
      },
      shops(){
        return this.$store.state.shops
      },
      roles(){
        return this.$store.state.roles
      },
    },
    methods:{
      getDataFromApi(){
        const { sortBy, descending, page, rowsPerPage } = this.pagination
        this.$store.dispatch(type.GET_STAFF_PLANS_PAGINATE, {sortBy, descending, page, rowsPerPage});
      },
      editItem (itemId) {
        this.$store.dispatch(type.GET_STAFF_PLAN, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_STAFF_PLAN, itemId)
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
              this.$store.dispatch(type.UPDATE_STAFF_PLAN, this.editedItem)
            } else {
              this.$store.dispatch(type.ADD_STAFF_PLAN, this.editedItem)
            }
            this.close()
          }
        })
      }
    }
  }
</script>
