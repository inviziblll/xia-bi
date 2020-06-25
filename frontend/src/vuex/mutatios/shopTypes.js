import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_SHOP_TYPES]: (state, shopTypes) => {
    Vue.set(state, 'shopTypes', shopTypes)
  },
  [type.ADD_SHOP_TYPE]: (state, shopType) => {
    state.shopTypes.push(shopType);
  },
  [type.UPDATE_SHOP_TYPE]: (state, shopType) => {
    state.shopTypes.forEach((element, index) => {
      if(element.id === shopType.id) {
        Vue.set(state.shopTypes, index, shopType);
      }
    });
  },
  [type.REMOVE_SHOP_TYPE]: (state, shopTypeId) => {
    let shopTypes = state.shopTypes.filter((element) => {
      if (element.id !== shopTypeId)
        return element
    });
    Vue.set(state, 'shopTypes', shopTypes);
  }
}
