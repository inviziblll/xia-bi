import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_SHOP_SHIFTS]: (state, shopShifts) => {
    Vue.set(state, 'shopShifts', shopShifts)
  },
  [type.GET_SHOP_SHIFT_PAGINATE]: (state, staffPlans) => {
    Vue.set(state, 'shopShiftsPaginate', staffPlans)
  },
  [type.ADD_SHOP_SHIFT]: (state, shopShift) => {
    state.shopShifts.push(shopShift);
  },
  [type.UPDATE_SHOP_SHIFT]: (state, shopShift) => {
    state.shopShifts.forEach((element, index) => {
      if(element.id === shopShift.id) {
        Vue.set(state.shopShifts, index, shopShift);
      }
    });
  },
  [type.REMOVE_SHOP_SHIFT]: (state, shopShiftId) => {
    let shopShifts = state.shopShifts.filter((element) => {
      if (element.id !== shopShiftId)
        return element
    });
    Vue.set(state, 'shopShifts', shopShifts);
  }
}
