import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_DISCOUNTS]: (state, discounts) => {
    Vue.set(state, 'discounts', discounts)
  },
  [type.ADD_DISCOUNT]: (state, discount) => {
    state.discounts.push(discount);
  },
  [type.UPDATE_DISCOUNT]: (state, discount) => {
    state.discounts.forEach((element, index) => {
      if(element.id === discount.id) {
        Vue.set(state.discounts, index, discount);
      }
    });
  },
  [type.REMOVE_DISCOUNT]: (state, discountId) => {
    let discounts = state.discounts.filter((element) => {
      if (element.id !== discountId)
        return element
    });
    Vue.set(state, 'discounts', discounts);
  }
}
