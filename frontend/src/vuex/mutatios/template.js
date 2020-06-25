import Vue from "vue";
import * as type from "../types";

export default {
  [type.CHANGE_NAV_BAR]: (state, drawer) => {
    Vue.set(state.templateSettings, 'drawer', drawer)
  },
  [type.GET_PAGE_CONTROLLER]: (state, params) => {
    Vue.set(state, 'pageController', params)
  }
}
