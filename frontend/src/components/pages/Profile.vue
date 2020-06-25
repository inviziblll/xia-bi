<template>
  <v-container grid-list-md>
  <v-layout wrap row>
    <v-flex xs12 sm6>
      <v-text-field
        label="ФИО"
        v-model="user.name"
        v-validate="'required'"
        :error-messages="errors.collect('user.name')"
        data-vv-name="user.name"
        data-vv-as="ФИО"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 sm6>
      <v-text-field
        label="Email"
        v-model="user.email"
        v-validate="'required|email'"
        :error-messages="errors.collect('user.email')"
        data-vv-name="user.email"
        data-vv-as="Email"
        required
      ></v-text-field>
    </v-flex>
    <v-flex xs12 sm6>
      <v-text-field
        label="Новый пароль"
        v-model="password"
        type="password"
        v-validate="'min:6'"
        :error-messages="errors.collect('password')"
        data-vv-name="password"
        data-vv-as="Новый пароль"
      ></v-text-field>
    </v-flex>
    <v-flex xs12>
      <v-btn color="primary" @click="updateProfile">Сохранить</v-btn>
    </v-flex>
  </v-layout>

  </v-container>
</template>

<script>
  import {UPDATE_USER} from '@/vuex/types'
  export default {
    name: 'Profile',
    data(){
      return {
        password: ''
      }
    },
    computed:{
      user(){
        return this.$store.state.sessions.user
      }
    },
    methods:{
      updateProfile () {
        this.$validator.validateAll().then(result => {
          if (result) {
            let user = this.user;
            if(this.password !== ''){
              user = Object.assign({}, user, {password:this.password})
            }
            this.$store.dispatch(UPDATE_USER, user)
          }
        })
      }
    }

  }
</script>
