<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Товары</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Создать товар</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                      label="Полное название товара"
                      v-model="editedItem.full_name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.full_name')"
                      data-vv-name="editedItem.full_name"
                      data-vv-as="Полное название товара"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field
                      label="Название товара"
                      v-model="editedItem.name"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.name')"
                      data-vv-name="editedItem.name"
                      data-vv-as="Название товара"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field
                      label="SKU"
                      v-model="editedItem.sku"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.sku')"
                      data-vv-name="editedItem.sku"
                      data-vv-as="SKU"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Группы товара"
                      autocomplete
                      :items="productGroups"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.groups"
                      v-validate="'required'"
                      multiple
                      chips
                      return-object
                      :error-messages="errors.collect('editedItem.groups')"
                      data-vv-name="editedItem.groups"
                      data-vv-as="Группы товара"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Тип товара"
                      autocomplete
                      :items="productTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_type_id')"
                      data-vv-name="editedItem.product_type_id"
                      data-vv-as="Тип товара"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Бренд товара"
                      autocomplete
                      :items="productBrands"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_brand_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_brand_id')"
                      data-vv-name="editedItem.product_brand_id"
                      data-vv-as="Бренд товара"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      label="Измерение"
                      autocomplete
                      :items="measureTypes"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.measure_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.measure_type_id')"
                      data-vv-name="editedItem.measure_type_id"
                      data-vv-as="Измерение"
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
        :items="products"
        :search="search"
        :rows-per-page-items='[25,50,100,{"text":"All","value":-1}]'
        rows-per-page-text="Количество строк:"
      >

        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.sku }}</td>
          <td>

              <v-chip v-for="(group, index) in props.item.groups" :key="index">
                {{ group.name }}
              </v-chip>

          </td>
          <td>{{ (props.item.type)? props.item.type.name : '' }}</td>
          <td>{{ (props.item.brand)? props.item.brand.name : '' }}</td>
          <td>{{ (props.item.measure)? props.item.measure.name : '' }}</td>
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
    name: 'Products',
    created(){
      this.$store.dispatch(type.GET_PRODUCTS);
      this.$store.dispatch(type.GET_PRODUCT_TYPES);
      this.$store.dispatch(type.GET_PRODUCT_BRANDS);
      this.$store.dispatch(type.GET_PRODUCT_GROUPS);
      this.$store.dispatch(type.GET_MEASURE_TYPES);
    },
    data() {
      return {
        dialog: false,
        search: '',
        editedIndex: -1,
        editedItem: {
          name: null,
          full_name: null,
          sku: null,
          description: null,
          groups: [],
          product_type_id: null,
          product_brand_id: null,
          measure_type_id: null
        },
        defaultItem: {
          name: null,
          full_name: null,
          sku: null,
          description: null,
          groups: [],
          product_type_id: null,
          product_brand_id: null,
          measure_type_id: null
        },
        headers: [
          {
            text: 'Название товара',
            align: 'left',
            value: 'name'
          },
          {
            text: 'SKU',
            align: 'left',
            value: 'sku'
          },
          {
            text: 'Группы товара',
            align: 'left',
            value: 'group.name'
          },
          {
            text: 'Тип товара',
            align: 'left',
            value: 'type.name'
          },
          {
            text: 'Бренд товара',
            align: 'left',
            value: 'brand.name'
          },
          {
            text: 'Измерение',
            align: 'left',
            value: 'measure.name'
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
        return this.editedIndex === -1 ? 'Создать товар' : 'Редактировать товар'
      },
      productTypes() {
        return this.$store.state.productTypes
      },
      productBrands() {
        return this.$store.state.productBrands
      },
      productGroups(){
        return this.$store.state.productGroups
      },
      measureTypes(){
        return this.$store.state.measureTypes
      },
      products() {
        return this.$store.getters.getProducts
      }
    },
    methods: {
      editItem(itemId) {
        this.$store.dispatch(type.GET_PRODUCT, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem(itemId) {
        confirm('Вы уверены, что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_PRODUCT, itemId);
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
              this.$store.dispatch(type.UPDATE_PRODUCT, this.editedItem);
            } else {
              this.$store.dispatch(type.ADD_PRODUCT, this.editedItem);
            }
            this.close()
          }
        })
      }
    }
  }
</script>
