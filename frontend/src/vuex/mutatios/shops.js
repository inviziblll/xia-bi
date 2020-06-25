import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_SHOPS]: (state, shops) => {
    Vue.set(state, 'shops', shops)
  },
  [type.ADD_SHOP]: (state, shop) => {
    state.shops.push(shop);
  },
  [type.UPDATE_SHOP]: (state, shop) => {
    state.shops.forEach((element, index) => {
      if(element.id === shop.id) {
        Vue.set(state.shops, index, shop);
      }
    });
  },
  [type.REMOVE_SHOP]: (state, shopId) => {
    let shops = state.shops.filter((element) => {
      if (element.id !== shopId)
        return element
    });
    Vue.set(state, 'shops', shops);
  }
}
