import Vue from "vue";
import * as type from "../types";

export default {
  [type.NOTIFICATION]: (state, notification) => {
    Vue.set(state, 'notification', notification)
  }
}
