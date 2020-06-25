<template>
  <v-menu
    ref="menu"
    lazy
    :close-on-content-click="false"
    v-model="menu"
    transition="scale-transition"
    offset-y
    full-width
    :nudge-right="40"
    min-width="290px"
    :return-value.sync="date"
  >
    <v-text-field
      slot="activator"
      :label="label"
      v-model="date"
      prepend-icon="event"
      readonly
    ></v-text-field>
    <v-date-picker
      locale="ru-ru"
      v-model="date"
      no-title
      scrollable>
      <v-spacer></v-spacer>
      <v-btn flat color="primary" @click="menu = false">Отмена</v-btn>
      <v-btn flat color="primary" @click="changeDate">Выбрать</v-btn>
    </v-date-picker>
  </v-menu>
</template>

<script>
  export default {
    name: "DataPicker",
    data(){
      return{
        menu: false,
        rules:[
          (v) => !!v  || 'Поле обязательно к заполнению.'
        ]
      }
    },
    props: {
      value: {
        type: [String]
      },
      label: {
        type: String,
        default: "Дата подписания"
      }
    },
    methods: {
      changeDate(){
        this.$refs.menu.save(this.date);
      }
    },
    computed:{
      date:{
        get(){
          if (this.value) {
            return this.value;
          }
          return null;
        },
        set(val){
          this.$emit('input', val);
        }
      }
    }
  }
</script>

<style scoped>

</style>
