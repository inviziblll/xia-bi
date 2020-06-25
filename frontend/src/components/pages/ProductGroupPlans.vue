<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Планы группов товаров</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить план группы товара</v-btn>
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
                      label="Тип"
                      autocomplete
                      :items="productGroupPlanTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_group_plan_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_group_plan_type_id')"
                      data-vv-name="editedItem.product_group_plan_type_id"
                      data-vv-as="Тип"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Группа"
                      autocomplete
                      :items="productGroups"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_group_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_group_id')"
                      data-vv-name="editedItem.product_group_id"
                      data-vv-as="Группа"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Количество" v-model="editedItem.value"></v-text-field>
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
        :items="productGroupPlans"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ (props.item.type)? props.item.type.name : ''}}</td>
          <td>{{ (props.item.group)? props.item.group.name : ''}}</td>
          <td>{{ props.item.date_from | date }}</td>
          <td>{{ props.item.date_to | date }}</td>
          <td>{{ props.item.value }}</td>
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
    name: 'ProductGroupPlans',
    created(){
      this.$store.dispatch(type.GET_PRODUCT_GROUPS);
      this.$store.dispatch(type.GET_PRODUCT_GROUP_PLAN_TYPES);
      this.$store.dispatch(type.GET_PRODUCT_GROUP_PLANS);
    },
    data () {
      return {
        dialog: false,
        menu: {
          date_from: false,
          date_to: false,
        },
        dateFormat:{
          date_from: null,
          date_to: null,
        },
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          product_group_plan_type_id:null,
          product_group_id:null,
          value:null,
          date_from:null,
          date_to:null
        },
        defaultItem:{
          name: null,
          product_group_plan_type_id:null,
          product_group_id:null,
          value:null,
          date_from:null,
          date_to:null
        },
        headers: [
          {
            text: 'Тип',
            align: 'left',
            value: 'type.name'
          },
          {
            text: 'Группа',
            align: 'left',
            value: 'group.name'
          },
          {
            text: 'Дата с',
            align: 'left',
            value: 'date_from'
          },
          {
            text: 'Дата по',
            align: 'left',
            value: 'value'
          },
          {
            text: 'Количество',
            align: 'left',
            value: 'date_to'
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
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить план группы товара' : 'Редактировать план группы товара'
      },
      productGroups(){
        return this.$store.state.productGroups;
      },
      productGroupPlanTypes(){
        return this.$store.state.productGroupPlanTypes;
      },
      productGroupPlans(){
        return this.$store.getters.getProductGroupPlans;
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(type.GET_PRODUCT_GROUP_PLAN, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_PRODUCT_GROUP_PLAN, itemId);
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
              this.$store.dispatch(type.UPDATE_PRODUCT_GROUP_PLAN, this.editedItem);
            } else {
              this.$store.dispatch(type.ADD_PRODUCT_GROUP_PLAN, this.editedItem)
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
