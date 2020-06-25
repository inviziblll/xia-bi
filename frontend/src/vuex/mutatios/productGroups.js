import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_PRODUCT_GROUPS]: (state, productGroups) => {
    Vue.set(state, 'productGroups', productGroups)
  },
  [type.ADD_PRODUCT_GROUP]: (state, productGroup) => {
    state.productGroups.push(productGroup);
  },
  [type.UPDATE_PRODUCT_GROUP]: (state, productGroup) => {
    state.productGroups.forEach((element, index) => {
      if(element.id === productGroup.id) {
        Vue.set(state.productGroups, index, productGroup);
      }
    });
  },
  [type.REMOVE_PRODUCT_GROUP]: (state, productGroupId) => {
    let productGroups = state.productGroups.filter((element) => {
      if (element.id !== productGroupId)
        return element
    });
    Vue.set(state, 'productGroups', productGroups);
  }
}
