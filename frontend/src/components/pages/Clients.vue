<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Клиенты</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить клиента</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs4>
                    <v-text-field
                      label="Имя"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Имяа"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Фамилия"
                      v-model="editedItem.last_name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.last_name')"
                      data-vv-name="editedItem.last_name"
                      data-vv-as="Фамилия"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Отчество"
                      v-model="editedItem.middle_name"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
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
                      :return-value.sync="editedItem.birth"
                    >
                      <v-text-field
                        slot="activator"
                        label="Дата рождения"
                        v-model="dateFormat.date"
                        prepend-icon="event"
                        readonly
                        v-validate="'required'"
                        :error-messages="errors.collect('editedItem.birth')"
                        data-vv-name="editedItem.birth"
                        data-vv-as="Дата рождения"
                        required
                      ></v-text-field>
                      <v-date-picker
                        locale="ru-ru"
                        v-model="editedItem.birth"
                        no-title scrollable
                        :first-day-of-week="1">
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu.date = false">Закрыть</v-btn>
                        <v-btn flat color="primary" @click="$refs.menuDateFrom.save(editedItem.birth)">Выбрать</v-btn>
                      </v-date-picker>
                    </v-menu>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Email"
                      v-model="editedItem.email"
                      v-validate="'email'"
                      :error-messages="errors.collect('editedItem.email')"
                      data-vv-name="editedItem.email"
                      data-vv-as="Email"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Телефон"
                      v-model="editedItem.phone"
                      v-validate="'numeric'"
                      :error-messages="errors.collect('editedItem.phone')"
                      data-vv-name="editedItem.phone"
                      data-vv-as="Телефон"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Описание клиента" v-model="editedItem.description"></v-text-field>
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
        :items="clients"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.birth | date }}</td>
          <td>{{ props.item.email }}</td>
          <td>{{ props.item.phone }}</td>
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
  import {GET_CLIENTS, GET_CLIENT, ADD_CLIENT, UPDATE_CLIENT, REMOVE_CLIENT} from '@/vuex/types';
  export default {
    name: 'Clients',
    created(){
      this.$store.dispatch(GET_CLIENTS, {page: 1});
    },
    data() {
      return {
        dialog: false,
        search: '',
        page: 1,
        menu: {
          date: false,
        },
        dateFormat:{
          date: null,
        },
        editedIndex: -1,
        editedItem: {
          name: null,
          last_name: null,
          middle_name: null,
          birth: null,
          email: null,
          phone: null,
          description: null
        },
        defaultItem: {
          name: null,
          last_name: null,
          middle_name: null,
          birth: null,
          email: null,
          phone: null,
          description: null
        },
        headers: [
          {
            text: 'ФИО',
            align: 'left',
            value: 'last_name'
          },
          {
            text: 'День рождение',
            align: 'left',
            value: 'birth'
          },
          {
            text: 'Email',
            align: 'left',
            value: 'email'
          },
          {
            text: 'Телефон',
            align: 'left',
            value: 'phone'
          },
          {
            text: 'Действия',
            align: 'center',
            sortable: false
          }
        ]
      }
    },
    watch: {
      "editedItem.birth"(val) {
        if (val != null)
          this.dateFormat.date = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat.date = null
      },
      page(val){
        this.$store.dispatch(GET_CLIENTS, {page: val});
      },
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить клиента' : 'Редактировать клиента';
      },
      clients() {
        return this.$store.state.clients;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_CLIENT, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true;
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(REMOVE_CLIENT, itemId);
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
              this.$store.dispatch(UPDATE_CLIENT, this.editedItem);
            } else {
              this.$store.dispatch(ADD_CLIENT, this.editedItem);
            }
            this.close();
          }
        });
      }
    }
  }
</script>
