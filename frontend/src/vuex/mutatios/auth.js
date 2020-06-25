import Vue from "vue";
import * as type from "../types";

export default {
  [type.SEND_AUTH]:(state, sessions) => {
    window.localStorage.setItem('TOKEN', sessions.access_token);
    Vue.set(state, 'sessions', sessions)
  },
  [type.CHECK_TOKEN]:(state, userData) => {
    Vue.set(state, 'sessions', userData)
  }
}
