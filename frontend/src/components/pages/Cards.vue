<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Карты</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить карту</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Номер карты"
                      v-model="editedItem.number"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.number')"
                      data-vv-name="editedItem.number"
                      data-vv-as="Номер карты"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-select
                      label="Клиент"
                      :items="clients"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.client_id"
                      data-vv-as="Клиент"
                      clearable
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
        :items="cards"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.number }}</td>
          <td>{{ (props.item.client)? props.item.client.name : ''}}</td>
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
  import {FETCH_CLIENTS, GET_CARDS, GET_CARD, ADD_CARD, UPDATE_CARD, REMOVE_CARD} from '@/vuex/types';

  export default {
    name: 'Cards',
    created(){
      this.$store.dispatch(FETCH_CLIENTS);
      this.$store.dispatch(GET_CARDS, {page: 1});
    },
    data () {
      return {
        dialog: false,
        search: '',
        page: 1,
        editedIndex: -1,
        editedItem: {
          client_id:null,
          number:null
        },
        defaultItem:{
          client_id:null,
          number:null
        },
        headers: [
          {
            text: 'Номер карты',
            align: 'left',
            value: 'number'
          },
          {
            text: 'Клиент',
            align: 'left',
            value: 'client.last_name'
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
      page(val){
        this.$store.dispatch(GET_CARDS, {page: val});
      },
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить карту' : 'Редактировать карту'
      },
      clients(){
        return this.$store.state.clients;
      },
      cards(){
        return this.$store.state.cards;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_CARD, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(REMOVE_CARD, itemId);
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
              this.$store.dispatch(UPDATE_CARD, this.editedItem);
            } else {
              this.$store.dispatch(ADD_CARD, this.editedItem)
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
