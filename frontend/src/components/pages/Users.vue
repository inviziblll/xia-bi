<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Сотрудники</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать сотрудника</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="ФИО сотрудника"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="ФИО менеджера"
                      required>
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Электронная почта"
                      v-model="editedItem.email"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.email')"
                      data-vv-name="editedItem.email"
                      data-vv-as="Электронная почта"
                      required>
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field
                      label="Пароль"
                      v-model="editedItem.password"
                      v-validate="{required: (editedIndex === -1)? true: false, min:6}"
                      :error-messages="errors.collect('editedItem.password')"
                      data-vv-name="editedItem.password"
                      data-vv-as="Пароль"
                      :required="(editedIndex === -1)? true: false"
                      >
                    </v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click.native="close">Закрыть</v-btn>
              <v-btn color="blue darken-1" flat @click.native="save">Сохранить</v-btn>
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
        :items="users"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.email }}</td>
          <td class="justify-end layout px-15">
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
  import {GET_USERS, GET_USER, ADD_USER, UPDATE_USER, REMOVE_USER} from '@/vuex/types'
  export default {
    name: 'Users',
    created(){
      this.$store.dispatch(GET_USERS)
    },
    data () {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: '',
          email:'',
          password: ''
        },
        defaultItem: {
          name: '',
          email:'',
          password: ''
        },
        headers: [
          {
            text: 'ФИО сотрудника',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Электронная почта',
            align: 'left',
            value: 'email'
          },
          {
            text: 'Действия',
            align:'right',
            value: 'name',
            sortable: false
          }
        ]
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Создать сотрудника' : 'Редактировать сотрудника'
      },
      users(){
        return this.$store.state.users;
      }
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(GET_USER, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(REMOVE_USER, itemId)
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
              this.$store.dispatch(UPDATE_USER, this.editedItem)
            } else {
              this.$store.dispatch(ADD_USER, this.editedItem)
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
