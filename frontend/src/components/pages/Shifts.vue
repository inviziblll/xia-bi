<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Список смен</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать смену</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название смены"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название смены"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Время с"
                      v-model="editedItem.hour_from"
                      v-validate="'required|numeric|max_value:24'"
                      :error-messages="errors.collect('editedItem.hour_from')"
                      data-vv-name="editedItem.hour_from"
                      data-vv-as="Время с"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Время до"
                      v-model="editedItem.hour_to"
                      v-validate="'required|numeric|max_value:24'"
                      :error-messages="errors.collect('editedItem.hour_to')"
                      data-vv-name="editedItem.hour_to"
                      data-vv-as="Время до"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Описание" v-model="editedItem.code"></v-text-field>
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
        :items="shifts"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.hour_from }}/{{ props.item.hour_to }}</td>
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
  import {GET_SHIFTS, GET_SHIFT, ADD_SHIFT, UPDATE_SHIFT, REMOVE_SHIFT} from '@/vuex/types';
  export default {
    name: 'Shifts',
    created(){
      this.$store.dispatch(GET_SHIFTS);
    },
    data() {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          hour_from: null,
          hour_to: null,
          code: null
        },
        defaultItem: {
          name: null,
          hour_from: null,
          hour_to: null,
          code: null
        },
        headers: [
          {
            text: 'Название смены',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Время с/до',
            sortable: false,
          },
          {
            text: 'Действия',
            align: 'center',
            sortable: false
          }
        ]
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Создать смену' : 'Редактировать смену'
      },
      shifts() {
        return this.$store.state.shifts
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_SHIFT, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(REMOVE_SHIFT, itemId)
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
              this.$store.dispatch(UPDATE_SHIFT, this.editedItem)
            } else {
              this.$store.dispatch(ADD_SHIFT, this.editedItem)
            }
            this.close()
          }
        })
      }
    }
  }
</script>
