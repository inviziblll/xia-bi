import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_PRODUCT_BRANDS]: (state, productBrands) => {
    Vue.set(state, 'productBrands', productBrands)
  },
  [type.ADD_PRODUCT_BRAND]: (state, productBrand) => {
    state.productBrands.push(productBrand);
  },
  [type.UPDATE_PRODUCT_BRAND]: (state, productBrand) => {
    state.productBrands.forEach((element, index) => {
      if(element.id === productBrand.id) {
        Vue.set(state.productBrands, index, productBrand);
      }
    });
  },
  [type.REMOVE_PRODUCT_BRAND]: (state, productBrandId) => {
    let productBrands = state.productBrands.filter((element) => {
      if (element.id !== productBrandId)
        return element
    });
    Vue.set(state, 'productBrands', productBrands);
  }
}
