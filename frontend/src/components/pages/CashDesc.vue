<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Описание оплат</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить описание оплаты</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название описание оплаты"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название описание оплаты"
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
        :items="cashDescs"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ (props.item.shop)? props.item.shop.name : ''}}</td>
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
  import {GET_SHOPS, GET_CASH_DESCS, GET_CASH_DESC, ADD_CASH_DESC, UPDATE_CASH_DESC, REMOVE_CASH_DESC} from '@/vuex/types';

  export default {
    name: 'CashDesc',
    created(){
      this.$store.dispatch(GET_SHOPS);
      this.$store.dispatch(GET_CASH_DESCS);
    },
    data () {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          shop_id:null,
          description:null
        },
        defaultItem:{
          name: null,
          shop_id:null,
          description:null
        },
        headers: [
          {
            text: 'Описание оплаты',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Магазин',
            align: 'left',
            value: 'shop.name'
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
        return this.editedIndex === -1 ? 'Добавить описание оплаты' : 'Редактировать описание оплаты'
      },
      shops(){
        return this.$store.state.shops;
      },
      cashDescs(){
        return this.$store.getters.getCashDescs;
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_CASH_DESC, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(REMOVE_CASH_DESC, itemId);
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
              this.$store.dispatch(UPDATE_CASH_DESC, this.editedItem);
            } else {
              this.$store.dispatch(ADD_CASH_DESC, this.editedItem)
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
