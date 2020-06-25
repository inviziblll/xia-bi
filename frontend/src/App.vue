<template>
  <v-app id="inspire">
    <router-view name="navbar"></router-view>
    <router-view name="toolbar"></router-view>
    <v-content>
      <v-container fluid v-bind:class="{'fill-height':$route.path === '/login'}">
        <router-view/>
      </v-container>
    </v-content>
    <v-snackbar
      :timeout="timeout"
      top
      right
      multi-line
      v-model="snackbar"
      :color="notification.type"
    >
      {{ notification.text }}
      <v-btn dark flat @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-app>
</template>

<script>
  import {NOTIFICATION} from "./vuex/types";
  import Vue from 'vue';
  export default {
    name: 'App',
    created() {
      Vue.checkAuth();
      this.$store.subscribe((mutation, state) => {
        switch (mutation.type) {
          case NOTIFICATION:
            this.snackbar = true;
            break;
          default:
            break;
        }
      });
    },
    data(){
      return {
        timeout: 3000,
        snackbar: false
      }
    },
    watch: {
      '$route' (to, from) {
        Vue.checkAuth();
      }
    },
    computed:{
      notification(){
        return this.$store.state.notification;
      }
    }
  }
</script>

<style lang="scss">
  .maxHeders{
    .input-group__selections__comma{
      height: 30px;
    }
  }
  .tableOverflow{
    .table__overflow{
      overflow-y: auto;
      height: 216px;
    }
  }
</style>
