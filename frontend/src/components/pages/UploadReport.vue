<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Список файлов</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="500px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Загрузить файл</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <file-upload v-model="editedItem.file" accept="*" label="Выберите файл..."></file-upload>
                  </v-flex>
                  <v-flex xs12>
                    <v-select
                      label="Тип"
                      autocomplete
                      :items="fileTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.file_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.file_type_id')"
                      data-vv-name="editedItem.file_type_id"
                      data-vv-as="Тип"
                      required
                    ></v-select>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click.native="close">Отменить</v-btn>
              <v-btn color="blue darken-1" flat @click="save">загрузить</v-btn>
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
        :items="fileLogs"
        :search="search"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.file_name }}</td>
          <td>{{ props.item.upload_date | dateTime }}</td>
          <td>{{ props.item.parse_date | dateTime }}</td>
          <td>{{ (props.item.file_status)? props.item.file_status.name : ''}}</td>
          <td>{{ (props.item.file_type)? props.item.file_type.name : ''}}</td>
          <td>{{ props.item.description }}</td>
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

  import FileUpload from '@/components/common/FileUpload';

  export default {
    created(){
      this.$store.dispatch(type.GET_FILE_TYPES);
      this.$store.dispatch(type.GET_FILE_LOGS);
    },
    name: 'UploadReport',
    data(){
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          file: null,
          file_type_id:null
        },
        defaultItem:{
          file: null,
          file_type_id:null
        },
        headers: [
          {
            text: 'Название файла',
            align: 'left',
            value: 'original_file_name'
          },
          {
            text: 'Дата загрузки',
            align: 'left',
            value: 'upload_date'
          },
          {
            text: 'Дата чтения',
            align: 'left',
            value: 'parse_date'
          },
          {
            text: 'Статус',
            align: 'left',
            value: 'status'
          },
          {
            text: 'Тип',
            align: 'left',
            value: 'file_type.name'
          },
          {
            text: 'Описание хода парсера',
            align: 'left',
            value: 'description'
          }
        ],
      }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Загрузить файл' : 'Редактировать файл'
      },
      fileTypes(){
        return this.$store.state.fileTypes;
      },
      fileLogs(){
        return this.$store.state.fileLogs;
      }
    },
    components: {FileUpload},
    methods:{
      fileStatus(statusType){
        switch(statusType){
          case 0:
            return 'В очереди на чтение';
            break;
          case 1:
            return 'Идет чтение';
            break;
          case 2:
            return 'Ошибка чтения';
            break;
          case 3:
            return 'Прочитан';
            break;
        }
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
            this.$store.dispatch(type.ADD_FILE_LOG, this.editedItem);
            this.close()
          }
        })
      }
    }
  }
</script>
