<template>
  <v-layout row wrap>
    <v-flex xs4 style="margin-bottom: 8px">
      <v-select
        class="maxHeders"
        label="Скидки"
        autocomplete
        :items="discounts"
        item-text="name"
        item-value="id"
        v-model="discount"
        return-object
        clearable
      ></v-select>
    </v-flex>
    <v-flex xs4 style="margin-bottom: 8px">
      <v-btn color="primary" dark @click="$emit('addDiscount', discount)"><v-icon left>add</v-icon>Добавить выбранную скидку</v-btn>
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
            <td>{{ props.item.name }}</td>
            <td>{{ props.item.value }}</td>
            <td class="justify-center layout px-0">
              <v-btn icon class="mx-0" @click="$emit('remDiscount', props.item)">
                <v-icon color="pink">delete</v-icon>
              </v-btn>
            </td>
        </template>
      </v-data-table>
    </v-flex>
  </v-layout>
</template>

<script>
  import * as type from '@/vuex/types';
  import {eventBus} from '@/main'

  export default {
    name: 'DiscountList',
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
      this.$store.dispatch(type.GET_DISCOUNTS_LIST);
    },
    data () {
      return {
        discount: null,
        headers: [
          {
            text: 'Наименование скидки',
            align: 'left',
            value: 'name',
            sortable: false
          },
          {
            text: 'Значение',
            align: 'left',
            value: 'value',
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
      discounts(){
        return this.$store.state.discounts;
      },
    },
    methods:{
      changeItem(item){
        // if(item.product_id != null)
        //   this.$store.dispatch(type.GET_PRODUCT, item.product_id).then(
        //     result => {
        //       item.product = result;
        //     });
        //
        // if(item.user_id != null)
        //   this.$store.dispatch(type.GET_USER, item.user_id).then(
        //     result => {
        //       item.user = result;
        //     });
      }
    }
  }
</script>

<style scoped lang="scss">
</style>
