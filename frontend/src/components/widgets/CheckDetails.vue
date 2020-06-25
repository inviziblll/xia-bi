<template>
  <v-layout row wrap>
    <v-flex xs12 style="margin-bottom: 8px">
      <v-btn color="primary" dark @click="$emit('addDetail')"><v-icon left>add</v-icon>Добавить позицию</v-btn>
    </v-flex>
    <v-flex xs12>
      <v-data-table
        :headers="headers"
        :items="value"
        hide-actions
        item-key="index"
        class="tableOverflow"
      >
        <template slot="items" slot-scope="props">
          <tr @click="props.expanded = !props.expanded">
            <td>{{ (props.item.product)? props.item.product.name : ''}}</td>
            <td>{{ (props.item.user)? props.item.user.name : ''}}</td>
            <td>{{ (props.item.checktype)? props.item.checktype.name : ''}}</td>
            <td>{{ props.item.count }}</td>
            <td>{{ props.item.price }}</td>
            <td>{{ props.item.price * props.item.count }}</td>
            <td>{{ props.item.discount }}</td>
            <td>{{ props.item.discount_percent }}</td>
            <td>
              <v-btn icon class="mx-0" @click="$emit('remDetail', props.item)">
                <v-icon color="pink">delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
        <template slot="expand" slot-scope="props">
          <v-card flat style="background-color: #f4f4f4">
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
                      v-model="props.item.product_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('props.item.product_id')"
                      data-vv-name="props.item.product_id"
                      data-vv-as="Товар"
                      required
                      single-line
                      v-on:input="changeItem(props.item)"
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
                      v-model="props.item.user_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('props.item.user_id')"
                      data-vv-name="props.item.user_id"
                      data-vv-as="Сотрудник"
                      required
                      single-line
                      v-on:input="changeItem(props.item)"
                    ></v-select>
                  </v-flex>
                  <v-flex xs4>
                    <v-select
                      class="maxHeders"
                      label="Тип позиции"
                      autocomplete
                      :items="checkTypes"
                      item-text="name"
                      item-value="id"
                      v-model="props.item.check_type_id"
                      v-validate="'required'"
                      :error-messages="errors.collect('props.item.check_type_id')"
                      data-vv-name="props.item.check_type_id"
                      data-vv-as="Тип позиции"
                      required
                      single-line
                      v-on:input="changeItem(props.item)"
                    ></v-select>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Колличество"
                      v-model="props.item.count"
                      v-validate="'required|numeric'"
                      :error-messages="errors.collect('props.item.count')"
                      data-vv-name="props.item.count"
                      data-vv-as="Колличество"
                      required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs4>
                    <v-text-field
                      label="Цена"
                      v-model="props.item.price"
                      v-validate="'required|decimal'"
                      :error-messages="errors.collect('props.item.price')"
                      data-vv-name="props.item.price"
                      data-vv-as="Цена"
                      required
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click="props.expanded = !props.expanded">Закрыть</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-data-table>
    </v-flex>
  </v-layout>
</template>

<script>
  import * as type from '@/vuex/types';
  import {eventBus} from '@/main'

  export default {
    name: 'CheckDetails',
    props:{
      checkHeadersId:{
        type: Number,
        default: null
      },
      value:{
        type:Array,
        default:[]
      }
    },
    created(){
      this.$store.dispatch(type.GET_PRODUCTS);
      this.$store.dispatch(type.GET_CHECK_TYPES);
      this.$store.dispatch(type.GET_USERS);
      this.$store.dispatch(type.GET_CHECK_DETAILS, this.checkHeadersId).then(
        result => {
          let index = 0;
          let val = result.reduce((newVal, oldVal) => {
            return [...newVal, Object.assign({}, oldVal, {index: index++})];
          }, []);
          this.$emit('input', val);
        }
      );
    },
    data () {
      return {
        headers: [
          {
            text: 'Товар',
            align: 'left',
            value: 'product.name',
            sortable: false
          },
          {
            text: 'Сотрудник',
            align: 'left',
            value: 'user.name',
            sortable: false
          },
          {
            text: 'Тип',
            align: 'left',
            value: 'type.name',
            sortable: false
          },
          {
            text: 'Колличество',
            align: 'left',
            value: 'count',
            sortable: false
          },
          {
            text: 'Цена',
            align: 'left',
            value: 'price',
            sortable: false
          },
          {
            text: 'Стоимость',
            align: 'left',
            value: 'amount',
            sortable: false
          },
          {
            text: 'Скидка',
            align: 'left',
            value: 'amount',
            sortable: false
          },
          {
            text: 'Процент скидки',
            align: 'left',
            value: 'amount',
            sortable: false
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
      users(){
        return this.$store.state.users;
      },
      products(){
        return this.$store.state.products;
      },
      checkTypes(){
        return this.$store.state.checkTypes;
      },
    },
    methods:{
      changeItem(item){
        if(item.product_id != null)
          this.$store.dispatch(type.GET_PRODUCT, item.product_id).then(
            result => {
              item.product = result;
            });

        if(item.user_id != null)
          this.$store.dispatch(type.GET_USER, item.user_id).then(
            result => {
              item.user = result;
            });
      }
    }
  }
</script>

<style scoped lang="scss">
</style>
