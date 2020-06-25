// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'babel-polyfill'
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './vuex'

import moment from 'moment'
moment.locale('ru');

import FiltersPlugin from './plugins/filter';
import FuncPlugin from './plugins/func';

import Vuetify from 'vuetify'
import VeeValidate, { Validator } from 'vee-validate'
import VeeValidateLocal from 'vee-validate/dist/locale/ru';
import 'vuetify/dist/vuetify.min.css'

Vue.use(FiltersPlugin);
Vue.use(FuncPlugin);

Vue.use(Vuetify, {
  theme: {
    primary: '#3478F6',
    orange: '#ff6709'
  }
});
Validator.localize('ru', VeeValidateLocal);
Vue.use(VeeValidate);

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
});
