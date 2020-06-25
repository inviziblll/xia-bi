import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_PRODUCT_REMAINS]: (state, productRemains) => {
    Vue.set(state, 'productRemains', productRemains)
  },
  [type.ADD_PRODUCT_REMAIN]: (state, productRemain) => {
    state.productRemains.push(productRemain);
  },
  [type.UPDATE_PRODUCT_REMAIN]: (state, productRemain) => {
    state.productRemains.forEach((element, index) => {
      if(element.id === productRemain.id) {
        Vue.set(state.productRemains, index, productRemain);
      }
    });
  },
  [type.REMOVE_PRODUCT_REMAIN]: (state, productRemainId) => {
    let productRemains = state.productRemains.filter((element) => {
      if (element.id !== productRemainId)
        return element
    });
    Vue.set(state, 'productRemains', productRemains);
  }
}
