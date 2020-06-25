<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Скидки</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить скидку</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название скидки"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название скидки"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Значение"
                      v-model="editedItem.value"
                      v-validate="'required|decimal'"
                      :error-messages="errors.collect('editedItem.value')"
                      data-vv-name="editedItem.value"
                      data-vv-as="Значение"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Описание скидки" v-model="editedItem.description"></v-text-field>
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
        :items="discounts"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
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
  import {GET_DISCOUNTS, GET_DISCOUNT, ADD_DISCOUNT, UPDATE_DISCOUNT, REMOVE_DISCOUNT} from '@/vuex/types';
  export default {
    name: 'Regions',
    created(){
      this.$store.dispatch(GET_DISCOUNTS, this.page);
    },
    data() {
      return {
        dialog: false,
        search: '',
        page: 1,
        editedIndex: -1,
        editedItem: {
          name: null,
          value: null,
          description: null
        },
        defaultItem: {
          name: null,
          value: null,
          description: null
        },
        headers: [
          {
            text: 'Название скидки',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Значение',
            align: 'left',
            value: 'value'
          },
          {
            text: 'Действия',
            align: 'center',
            sortable: false
          }
        ]
      }
    },
    watch:{
      page(val){
        this.$store.dispatch(GET_DISCOUNTS, val);
      },
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить скидку' : 'Редактировать скидку';
      },
      discounts() {
        return this.$store.state.discounts;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_DISCOUNT, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true;
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(REMOVE_DISCOUNT, itemId);
      },

      close () {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
          this.$nextTick(() => this.$validator.reset());
        }, 300);
      },

      save () {
        this.$validator.validateAll().then(result => {
          if (result) {
            if (this.editedIndex > -1) {
              this.$store.dispatch(UPDATE_DISCOUNT, this.editedItem);
            } else {
              this.$store.dispatch(ADD_DISCOUNT, this.editedItem);
            }
            this.close();
          }
        });
      }
    }
  }
</script>
