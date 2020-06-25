<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Склады</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить склад</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название склада"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название склада"
                      required
                    ></v-text-field>
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
                    <v-select
                      label="Тип"
                      autocomplete
                      :items="warehouseTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.warehouse_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.warehouse_type_id')"
                      data-vv-name="editedItem.warehouse_type_id"
                      data-vv-as="Тип"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Описание" v-model="editedItem.description"></v-text-field>
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
        :items="warehouses"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ (props.item.shop)? props.item.shop.name : ''}}</td>
          <td>{{ (props.item.type)? props.item.type.name : ''}}</td>
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
  import {GET_SHOPS, GET_WAREHOUSE_TYPES, GET_WAREHOUSES, GET_WAREHOUSE, ADD_WAREHOUSE, UPDATE_WAREHOUSE, REMOVE_WAREHOUSE} from '@/vuex/types';

  export default {
    name: 'Warehouse',
    created(){
      this.$store.dispatch(GET_SHOPS);
      this.$store.dispatch(GET_WAREHOUSE_TYPES);
      this.$store.dispatch(GET_WAREHOUSES);
    },
    data () {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          warehouse_type_id:null,
          shop_id:null,
          description:null
        },
        defaultItem:{
          name: null,
          warehouse_type_id:null,
          shop_id:null,
          description:null
        },
        headers: [
          {
            text: 'Название',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Магазин',
            align: 'left',
            value: 'shop.name'
          },
          {
            text: 'Тип',
            align: 'left',
            value: 'type.name'
          },
          {
            text: 'Действия',
            align:'center',
            sortable: false
          }
        ],
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить склад' : 'Редактировать склад'
      },
      shops(){
        return this.$store.state.shops;
      },
      warehouseTypes(){
        return this.$store.state.warehouseTypes;
      },
      warehouses(){
        return this.$store.getters.getWarehouses;
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_WAREHOUSE, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(REMOVE_WAREHOUSE, itemId);
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
              this.$store.dispatch(UPDATE_WAREHOUSE, this.editedItem);
            } else {
              this.$store.dispatch(ADD_WAREHOUSE, this.editedItem)
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
