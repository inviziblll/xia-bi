<template>
  <v-toolbar
    color="orange"
    dark
    app
    :clipped-left="$vuetify.breakpoint.lgAndUp"
    fixed
  >
    <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
      <v-toolbar-side-icon @click.stop="menuChange()"></v-toolbar-side-icon>
      <router-link :to="{name:'Home'}" class="logo"><img src="@/assets/img/logo.png"/></router-link>
      <router-link tag="span" :to="{name:'Home'}" class="hidden-sm-and-down" style="cursor: pointer"> Xiaomi</router-link>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-menu bottom left>
      <v-btn slot="activator" icon dark>
        <v-icon>person</v-icon>
      </v-btn>
      <v-list>
        <v-list-tile :to="{name: 'Profile'}">
          <v-list-tile-action>
            <v-icon>person</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>Профиль</v-list-tile-title>
        </v-list-tile>
        <v-list-tile @click="logout">
          <v-list-tile-action>
            <v-icon>power_settings_new</v-icon>
          </v-list-tile-action>
          <v-list-tile-title> Выйти</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </v-toolbar>
</template>

<script>
  import {CHANGE_NAV_BAR, LOGOUT} from '@/vuex/types';
  export default {
    name: "ToolBar",
    computed:{
      drawer(){
        return this.$store.state.templateSettings.drawer
      }
    },
    methods:{
      menuChange(){
        this.$store.commit(CHANGE_NAV_BAR, !this.drawer)
      },
      logout(){
        this.$store.dispatch(LOGOUT, !this.drawer)
      }
    }
  }
</script>

<style scoped lang="scss">
  .logo{
    width: 40px;
    height: 40px;
    margin-right: 12px;
    & > img{
      width: 40px;
      height: 40px;
    }
  }
  .toolbar{
    &__title{
      display: flex;
      align-items: center;
    }
  }
</style>
