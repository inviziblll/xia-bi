<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Магазины</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать магазин</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Название магазина"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название магазина"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Город магазина"
                      autocomplete
                      :items="cities"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.city_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.city_id')"
                      data-vv-name="editedItem.city_id"
                      data-vv-as="Город магазина"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Тип магазина"
                      autocomplete
                      :items="shopTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.shop_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.shop_type_id')"
                      data-vv-name="editedItem.shop_type_id"
                      data-vv-as="Тип магазина"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Дивизион"
                      autocomplete
                      :items="divisions"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.division_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.division_id')"
                      data-vv-name="editedItem.division_id"
                      data-vv-as="Дивизион"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Компании"
                      autocomplete
                      :items="companies"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.company_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.company_id')"
                      data-vv-name="editedItem.company_id"
                      data-vv-as="Компании"
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
              <v-btn color="blue darken-1" flat @click.native="save">Сохранить</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-spacer></v-spacer>
        <v-text-field
          append-icon="search"
          label="Search"
          single-line
          hide-details
          v-model="search"
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="shops"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >

        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ (props.item.type)? props.item.type.name : '' }}</td>
          <td>{{ (props.item.city)? props.item.city.name : '' }}</td>
          <td>{{ (props.item.division)? props.item.division.name : '' }}</td>
          <td>{{ (props.item.company)? props.item.company.name : '' }}</td>
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
    name: 'Shops',
    created(){
      this.$store.dispatch(type.GET_SHOPS);
      this.$store.dispatch(type.GET_SHOP_TYPES);
      this.$store.dispatch(type.GET_DIVISIONS);
      this.$store.dispatch(type.GET_CITIES);
      this.$store.dispatch(type.GET_COMPANIES);
    },
    data() {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          description: null,
          city_id: null,
          company_id: null,
          division_id: null,
          shop_type_id: null
        },
        defaultItem: {
          name: null,
          description: null,
          city_id: null,
          company_id: null,
          division_id: null,
          shop_type_id: null
        },
        headers: [
          {
            text: 'Название Магазина',
            align: 'left',
            value: 'name'
          },
          {
            text: 'Тип Магазина',
            align: 'left',
            value: 'type.name'
          },
          {
            text: 'Город',
            align: 'left',
            value: 'city.name'
          },
          {
            text: 'Дивизион',
            align: 'left',
            value: 'division.name'
          },
          {
            text: 'Компания',
            align: 'left',
            value: 'company.name'
          },
          {
            text: 'Действия',
            align: 'center',
            sortable: false
          }
        ],
      }
    },
    computed: {
      formTitle() {
        return this.editedIndex === -1 ? 'Создать магазин' : 'Редактировать магазин'
      },
      divisions() {
        return this.$store.state.divisions
      },
      companies() {
        return this.$store.state.companies
      },
      shopTypes(){
        return this.$store.state.shopTypes
      },
      cities(){
        return this.$store.state.cities
      },
      shops() {
        return this.$store.getters.getShops
      }
    },
    methods: {
      editItem(itemId) {
        this.$store.dispatch(type.GET_SHOP, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem(itemId) {
        confirm('Are you sure you want to delete this item?') && this.$store.dispatch(type.REMOVE_SHOP, itemId);
      },

      close() {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
          this.$nextTick(() => this.$validator.reset())
        }, 300)
      },

      save() {
        this.$validator.validateAll().then(result => {
          if (result) {
            if (this.editedIndex > -1) {
              this.$store.dispatch(type.UPDATE_SHOP, this.editedItem);
            } else {
              this.$store.dispatch(type.ADD_SHOP, this.editedItem);
            }
            this.close()
          }
        })
      }
    }
  }
</script>
