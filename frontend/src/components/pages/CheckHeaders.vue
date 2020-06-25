<template>
  <v-layout row>
    <v-flex xs12>
      <v-card-title>
        <v-subheader class="title">Чеки</v-subheader>
        <v-btn color="primary" dark class="mb-2" @click="dialog = true">Добавить чек</v-btn>
        <v-dialog v-if="dialog" v-model="dialog" persistent max-width="1024px">
          <v-card height="444px">
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text class="modalContent">
              <v-tabs>
                <v-tab>
                  Главное
                </v-tab>
                <v-tab>
                  Продажи
                </v-tab>
                <v-tab>
                  Скидки
                </v-tab>
                <v-tab-item style="margin-top: 8px">
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs6>
                        <v-text-field
                          label="Номер чека"
                          v-model="editedItem.check_number"
                          v-validate="'required'"
                          :error-messages="errors.collect('editedItem.check_number')"
                          data-vv-name="editedItem.check_number"
                          data-vv-as="Номер чека"
                          required
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6>
                        <v-text-field
                          label="Номер изменения"
                          v-model="editedItem.change_number"
                          v-validate="'required'"
                          :error-messages="errors.collect('editedItem.change_number')"
                          data-vv-name="editedItem.change_number"
                          data-vv-as="Номер изменения"
                          required
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs6>
                        <v-select
                          label="Операция"
                          autocomplete
                          :items="checkOperations"
                          item-text="name"
                          item-value="id"
                          v-model="editedItem.check_operation_id"
                          v-validate="'required'"
                          :error-messages="errors.collect('editedItem.check_operation_id')"
                          data-vv-name="editedItem.check_operation_id"
                          data-vv-as="Операция"
                          required
                        ></v-select>
                      </v-flex>
                      <v-flex xs6>
                        <v-select
                          class="maxHeders"
                          label="Оплата"
                          autocomplete
                          :items="cashDescs"
                          item-text="name"
                          item-value="id"
                          v-model="editedItem.cash_desk_id"
                          v-validate="'required'"
                          :error-messages="errors.collect('editedItem.cash_desk_id')"
                          data-vv-name="editedItem.cash_desk_id"
                          data-vv-as="Оплата"
                          required
                        ></v-select>
                      </v-flex>
                      <v-flex xs6>
                        <v-select
                          class="maxHeders"
                          label="Бонусная карта"
                          autocomplete
                          :items="cards"
                          item-text="number"
                          item-value="id"
                          v-model="editedItem.card_id"
                          v-validate="'required'"
                          :error-messages="errors.collect('editedItem.card_id')"
                          data-vv-name="editedItem.card_id"
                          data-vv-as="Бонусная карта"
                          required
                        ></v-select>
                      </v-flex>
                      <v-flex xs6>
                        <v-menu
                          ref="menuDate"
                          lazy
                          :close-on-content-click="false"
                          v-model="menuDate"
                          transition="scale-transition"
                          offset-y
                          full-width
                          :nudge-right="40"
                          min-width="290px"
                          :return-value.sync="editedItem.date"
                        >
                          <v-text-field
                            slot="activator"
                            label="Дата смены"
                            v-model="dateFormat"
                            prepend-icon="event"
                            readonly
                            v-validate="'required'"
                            :error-messages="errors.collect('editedItem.date')"
                            data-vv-name="editedItem.date"
                            data-vv-as="Дата смены"
                            required
                          ></v-text-field>
                          <v-date-picker
                            locale="ru-ru"
                            v-model="editedItem.date"
                            no-title scrollable
                            :first-day-of-week="1">
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="menuDate = false">Закрыть</v-btn>
                            <v-btn flat color="primary" @click="$refs.menuDate.save(editedItem.date)">Выбрать</v-btn>
                          </v-date-picker>
                        </v-menu>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-tab-item>
                <v-tab-item style="margin-top: 8px">
                  <check-details
                    :checkHeadersId="(editedIndex !== -1)?editedItem.id:null"
                    v-model="details"
                    v-on:addDetail="addDetail"
                    v-on:remDetail="remDetail"
                  ></check-details>
                </v-tab-item>
                <v-tab-item style="margin-top: 8px">
                  <discount-list
                    :checkHeadersId="(editedIndex !== -1)?editedItem.id:null"
                    v-model="editedItem.discounts"
                    v-on:addDiscount="addDiscount"
                    v-on:remDiscount="remDiscount"
                  ></discount-list>
                </v-tab-item>
              </v-tabs>
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
        :items="checkHeaders"
        hide-actions
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.check_number }}</td>
          <td>{{ props.item.change_number }}</td>
          <td>{{ (props.item.checkoperation)? props.item.checkoperation.name : ''}}</td>
          <td>{{ (props.item.cashdesk)? props.item.cashdesk.name : ''}}</td>
          <td>{{ (props.item.card)? props.item.card.number : ""}}</td>
          <td>{{ props.item.date | dateTime}}</td>
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
  import * as type from '@/vuex/types';

  import CheckDetails from '@/components/widgets/CheckDetails';
  import DiscountList from '@/components/widgets/DiscountList';

  export default {
    name: 'CheckHeaders',
    created(){
      this.$store.dispatch(type.GET_CHECK_TYPES);
      this.$store.dispatch(type.GET_CHECK_OPERATIONS);
      this.$store.dispatch(type.GET_CASH_DESCS);
        this.$store.dispatch(type.GET_CARDS,{page: 1, search:''});
      this.$store.dispatch(type.GET_CHECK_HEADERS, {page: 1, search:''});
    },
    data () {
      return {
        dialog: false,
        page: 1,
        menuDate: false,
        dateFormat: null,
        search: '',
        details:[],
        editedIndex: -1,
        editedItem: {
          check_operation_id: null,
          cash_desk_id: null,
          date: null,
          change_number: null,
          check_number: null,
          discounts:[],
          card_id: null
        },
        defaultItem:{
          check_operation_id: null,
          cash_desk_id: null,
          date: null,
          change_number: null,
          check_number: null,
          discounts:[],
          card_id: null
        },
        headers: [
          {
            text: 'Номер чека',
            align: 'left',
            value: 'check_number',
            sortable: false
          },
          {
            text: 'Номер изменения',
            align: 'left',
            value: 'change_number',
            sortable: false
          },
          {
            text: 'Операция чека',
            align: 'left',
            value: 'operation.name',
            sortable: false
          },
          {
            text: 'Оплата',
            align: 'left',
            value: 'cash.name',
            sortable: false
          },
          {
            text: 'Бонусная карта',
            align: 'left',
            value: 'card_id',
            sortable: false
          },

          {
            text: 'Дата',
            align: 'left',
            value: 'date',
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
    components:{CheckDetails, DiscountList},
    watch:{
      "editedItem.date"(val) {
        if(val != null)
          this.dateFormat = (new Date(val)).toLocaleDateString();
        else
          this.dateFormat = null
      },
      page(val){

        this.$store.dispatch(type.GET_CHECK_HEADERS, {page: val, search:''});
      },
    },
    computed: {

      formTitle () {
        return this.editedIndex === -1 ? 'Добавить чек' : 'Редактировать чек'
      },
      checkTypes(){
        return this.$store.state.checkTypes;
      },
      checkOperations(){
        return this.$store.state.checkOperations;
      },
      cashDescs(){
        return this.$store.state.cashDescs;
      },
      cards(){
        return this.$store.state.cards;
      },
      checkHeaders(){
        return this.$store.state.checkHeaders;
      },
      pageController(){
        return this.$store.state.pageController
      }
    },
    methods:{
      addDetail(){
        this.details.push({
          index: this.details.length,
          check_header_id: null,
          product_id: null,
          product:{
            name: null
          },
          user_id: null,
          user:{
            name: null,
          },
          count: 0,
          price: '0',
          amount: '0'
        })
      },
      remDetail(item){
        let isRem = confirm('Вы уверены что хотите удалить запись?');
        if(isRem){
          if(item.id){
              this.$store.dispatch(type.REMOVE_CHECK_DETAIL, item.id);
          }
          this.details.splice(this.details.indexOf(item), 1);
        }
      },
      editItem (itemId) {
        this.$store.dispatch(type.GET_CHECK_HEADER, itemId).then(
          result => {
            this.editedIndex = itemId;
            this.editedItem = Object.assign({}, result);
            this.dialog = true
          });
      },

      addDiscount(discount){
        this.editedItem.discounts.push(discount)
      },
      remDiscount(item){
        let isRem = confirm('Вы уверены что хотите удалить запись?');
        if(isRem){
          //@TODO доделать удаление скидок
        }
      },
      deleteItem (itemId) {
        confirm('Вы уверены что хотите удалить запись?') && this.$store.dispatch(type.REMOVE_CHECK_HEADER, itemId);
      },

      close () {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
          this.details = [];
          this.$nextTick(() => this.$validator.reset())
        }, 300)
      },

      save () {
        this.$validator.validateAll().then(result => {
          if (result) {
            if (this.editedIndex > -1) {
              this.$store.dispatch(type.UPDATE_CHECK_HEADER, {checkHeader: this.editedItem, details: this.details});
            } else {
              this.$store.dispatch(type.ADD_CHECK_HEADER, {checkHeader: this.editedItem, details: this.details});
            }
            this.close()
          }else{
            this.$store.commit(type.NOTIFICATION, {type: 'error', text: "Заполните все поля"})
          }
        })
      }
    }
  }
</script>

<style scoped lang="scss">
  .modalContent{
    height: 328px;
    overflow-y: hidden;
    padding-top: 0;
  }
</style>
