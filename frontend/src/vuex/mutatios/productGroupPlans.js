import Vue from "vue";
import * as type from "../types";
import productGroupPlanTypes from "../actions/productGroupPlanTypes";

export default {
  [type.GET_PRODUCT_GROUP_PLANS]: (state, productGroupPlans) => {
    Vue.set(state, 'productGroupPlans', productGroupPlans)
  },
  [type.ADD_PRODUCT_GROUP_PLAN]: (state, productGroupPlan) => {
    state.productGroupPlans.push(productGroupPlan);
  },
  [type.UPDATE_PRODUCT_GROUP_PLAN]: (state, productGroupPlan) => {
    state.productGroupPlans.forEach((element, index) => {
      if(element.id === productGroupPlan.id) {
        Vue.set(state.productGroupPlans, index, productGroupPlan);
      }
    });
  },
  [type.REMOVE_PRODUCT_GROUP_PLAN]: (state, productGroupPlanId) => {
    let productGroupPlans = state.productGroupPlans.filter((element) => {
      if (element.id !== productGroupPlanId)
        return element
    });
    Vue.set(state, 'productGroupPlans', productGroupPlans);
  }
}
