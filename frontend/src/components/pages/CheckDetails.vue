<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Чек № {{ $route.params.checkHeaderId }}</v-subheader>
        <v-dialog v-model="dialog" persistent max-width="960px">
          <v-btn color="primary" dark slot="activator" class="mb-2">Добавить позицию</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs6>
                    <v-select
                      class="maxHeders"
                      label="Товар"
                      autocomplete
                      :items="products"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.product_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.product_id')"
                      data-vv-name="editedItem.product_id"
                      data-vv-as="Товар"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs6>
                    <v-select
                      class="maxHeders"
                      label="Сотрудник"
                      autocomplete
                      :items="users"
                      item-text="name"
                      item-value="id"
                      v-model="editedItem.user_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('editedItem.user_id')"
                      data-vv-name="editedItem.user_id"
                      data-vv-as="Сотрудник"
                      required
                    ></v-select>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Колличество"
                      v-model="editedItem.count"
                      v-validate="'required|numeric'"
                      :error-messages="errors.collect('editedItem.count')"
                      data-vv-name="editedItem.count"
                      data-vv-as="Колличество"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Цена"
                      v-model="editedItem.price"
                      v-validate="'required|decimal'"
                      :error-messages="errors.collect('editedItem.price')"
                      data-vv-name="editedItem.price"
                      data-vv-as="Цена"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Сумма"
                      readonly
                      v-model="editedItem.amount"
                      v-validate="'required|decimal'"
                      :error-messages="errors.collect('editedItem.amount')"
                      data-vv-name="editedItem.amount"
                      data-vv-as="Сумма"
                      required
                    ></v-text-field>
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
      </v-card-title>
      <!--<v-layout row>-->
        <!--<v-flex xs12>-->
          <!--123-->
        <!--</v-flex>-->
      <!--</v-layout>-->
      <v-data-table
        :headers="headers"
        :items="CheckDetails"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ (props.item.product)? props.item.product.name : ''}}</td>
          <td>{{ (props.item.user)? props.item.user.name : ''}}</td>
          <td>{{ props.item.count }}</td>
          <td>{{ props.item.price }}</td>
          <td>{{ props.item.amount }}</td>
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
      </v-data-table>
    </v-flex>
  </v-layout>
</template>

<script>
  import * as type from '@/vuex/types';

  export default {
    name: 'CheckDetails',
    created(){
      this.$store.dispatch(type.GET_PRODUCTS);
      this.$store.dispatch(type.GET_USERS);
      this.$store.dispatch(type.GET_CHECK_HEADER_DETAIL, this.$route.params.checkHeaderId);
      this.$store.dispatch(type.GET_CHECK_DETAILS, this.$route.params.checkHeaderId);
    },
    data () {
      return {
        dialog: false,
        editedIndex: -1,
        editedItem: {
          check_header_id: this.$route.params.checkHeaderId,
          product_id: null,
          user_id: null,
          count: null,
          price: null,
          amount: '0'
        },
        defaultItem:{
          check_header_id: this.$route.params.checkHeaderId,
          product_id: null,
          user_id: null,
          count: null,
          price: null,
          amount: '0'
        },
        headers: [
          {
            text: 'Товар',
            align: 'left',
            value: 'product.name'
          },
          {
            text: 'Сотрудник',
            align: 'left',
            value: 'user.name'
          },
          {
            text: 'Колличество',
            align: 'left',
            value: 'count'
          },
          {
            text: 'Цена',
            align: 'left',
            value: 'price'
          },
          {
            text: 'Стоимость',
            align: 'left',
            value: 'amount'
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
        return this.editedIndex === -1 ? 'Добавить позицию' : 'Редактировать позицию'
      },
      checkHeader(){
        return this.$store.state.checkHeader;
      },
      users(){
        return this.$store.state.users;
      },
      products(){
        return this.$store.state.products;
      },
      CheckDetails(){
        return this.$store.state.checkDetails;
      }
    },
    watch:{
      "editedItem.price"(){
        this.editedItem.amount = (this.editedItem.price * this.editedItem.count).toString();
      },
      "editedItem.count"(){
        this.editedItem.amount = (this.editedItem.price * this.editedItem.count).toString();
      },
    },
    methods:{
      editItem (itemId) {
        this.$store.dispatch(type.GET_CHECK_DETAIL, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_CHECK_DETAIL, itemId);
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
              this.$store.dispatch(type.UPDATE_CHECK_DETAIL, this.editedItem);
            } else {
              this.$store.dispatch(type.ADD_CHECK_DETAIL, this.editedItem)
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
