<template>
  <v-layout row align-center justify-center>
    <v-flex xs12 sm8 md4>
      <v-card class="elevation-12">
        <v-toolbar dark color="orange">
          <v-toolbar-title>Вход</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <span>Source</span>
          </v-tooltip>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field prepend-icon="person" name="login" label="Логин" v-model="email" type="text"></v-text-field>
            <v-text-field prepend-icon="lock" name="password" label="Пароль" v-model="password" type="password"></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn flat @click="send">Войти</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
  import { SEND_AUTH } from '@/vuex/types'
  export default {
    name: 'Login',
    data(){
      return {
        email: '',
        password: ''
      }
    },
    methods:{
      send(){
        this.$store.dispatch(SEND_AUTH, {email: this.email, password: this.password}).then(() => {
          this.$router.push({ name: 'Home' })
        })
      }
    }
  }
</script>
