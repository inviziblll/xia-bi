import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_PRODUCT_TYPES]: (state, productTypes) => {
    Vue.set(state, 'productTypes', productTypes)
  },
  [type.ADD_PRODUCT_TYPE]: (state, productType) => {
    state.productTypes.push(productType);
  },
  [type.UPDATE_PRODUCT_TYPE]: (state, productType) => {
    state.productTypes.forEach((element, index) => {
      if(element.id === productType.id) {
        Vue.set(state.productTypes, index, productType);
      }
    });
  },
  [type.REMOVE_PRODUCT_TYPE]: (state, productTypeId) => {
    let productTypes = state.productTypes.filter((element) => {
      if (element.id !== productTypeId)
        return element
    });
    Vue.set(state, 'productTypes', productTypes);
  }
}
