import Vue from "vue";
import * as type from "../types";
import productGroupPlanTypes from "../actions/productGroupPlanTypes";

export default {
  [type.GET_PRODUCT_GROUP_PLAN_TYPES]: (state, productGroupPlanTypes) => {
    Vue.set(state, 'productGroupPlanTypes', productGroupPlanTypes)
  },
  [type.ADD_PRODUCT_GROUP_PLAN_TYPE]: (state, productGroupPlanType) => {
    state.productGroupPlanTypes.push(productGroupPlanType);
  },
  [type.UPDATE_PRODUCT_GROUP_PLAN_TYPE]: (state, productGroupPlanType) => {
    state.productGroupPlanTypes.forEach((element, index) => {
      if(element.id === productGroupPlanType.id) {
        Vue.set(state.productGroupPlanTypes, index, productGroupPlanType);
      }
    });
  },
  [type.REMOVE_PRODUCT_GROUP_PLAN_TYPE]: (state, productGroupPlanTypeId) => {
    let productGroupPlanTypes = state.productGroupPlanTypes.filter((element) => {
      if (element.id !== productGroupPlanTypeId)
        return element
    });
    Vue.set(state, 'productGroupPlanTypes', productGroupPlanTypes);
  }
}
