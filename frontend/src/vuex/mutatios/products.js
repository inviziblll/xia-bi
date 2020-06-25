import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_PRODUCTS]: (state, products) => {
    Vue.set(state, 'products', products)
  },
  [type.ADD_PRODUCT]: (state, product) => {
    state.products.push(product);
  },
  [type.UPDATE_PRODUCT]: (state, product) => {
    state.products.forEach((element, index) => {
      if(element.id === product.id) {
        Vue.set(state.products, index, product);
      }
    });
  },
  [type.REMOVE_PRODUCT]: (state, productId) => {
    let products = state.products.filter((element) => {
      if (element.id !== productId)
        return element
    });
    Vue.set(state, 'products', products);
  }
}
