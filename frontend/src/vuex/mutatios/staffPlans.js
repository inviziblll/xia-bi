import Vue from "vue";
import * as type from "../types";
import HTTP from "../../axios";
import state from "../state";

export default {
  [type.GET_STAFF_PLANS]: (state, staffPlans) => {
    Vue.set(state, 'staffPlans', staffPlans)
  },
  [type.GET_STAFF_PLANS_PAGINATE]: (state, staffPlans) => {
    Vue.set(state, 'staffPlansPaginate', staffPlans)
  },
  [type.ADD_STAFF_PLAN]: (state, staffPlan) => {
    state.staffPlans.push(staffPlan);
  },
  [type.UPDATE_STAFF_PLAN]: (state, staffPlan) => {
    state.staffPlans.forEach((element, index) => {
      if(element.id === staffPlan.id) {
        Vue.set(state.staffPlans, index, staffPlan);
      }
    });
  },
  [type.REMOVE_STAFF_PLAN]: (state, staffPlanId) => {
    let staffPlans = state.staffPlans.filter((element) => {
      if (element.id !== staffPlanId)
        return element
    });
    Vue.set(state, 'staffPlans', staffPlans);
  }
}
