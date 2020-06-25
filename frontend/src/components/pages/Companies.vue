<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Компании</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать компанию</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название компании"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название компании"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Префикс компании"
                      v-model="editedItem.prefix"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.prefix')"
                      data-vv-name="editedItem.prefix"
                      data-vv-as="Префикс компании"
                      required
                    ></v-text-field>
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
        :items="companies"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.prefix }}</td>
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
  import {GET_COMPANIES, GET_COMPANY, ADD_COMPANY, UPDATE_COMPANY, REMOVE_COMPANY} from '@/vuex/types';
  export default {
    name: 'Companies',
    created(){
      this.$store.dispatch(GET_COMPANIES);
    },
    data () {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          prefix:null,
          description:null
        },
        defaultItem:{
          name: null,
          prefix:null,
          description:null
        },
        headers: [
          {
            text: 'Название Компании',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Префикс Компании',
            align: 'left',
            value: 'prefix'
          },
          {
            text: 'Действия',
            align:'center',
            value: 'name',
            sortable: false
          }
        ]
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Создать компанию' : 'Редактировать компанию'
      },
      companies(){
        return this.$store.state.companies;
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_COMPANY, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(REMOVE_COMPANY, itemId)
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
              this.$store.dispatch(UPDATE_COMPANY, this.editedItem)
            } else {
              this.$store.dispatch(ADD_COMPANY, this.editedItem)
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
