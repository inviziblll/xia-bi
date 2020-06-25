import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_SHIFTS]: (state, shifts) => {

    Vue.set(state, 'shifts', shifts)
  },
  [type.ADD_SHIFT]: (state, shift) => {
    state.shifts.push(shift);
  },
  [type.UPDATE_SHIFT]: (state, shift) => {
    state.shifts.forEach((element, index) => {
      if(element.id === shift.id) {
        Vue.set(state.shifts, index, shift);
      }
    });
  },
  [type.REMOVE_SHIFT]: (state, shiftId) => {
    let shifts = state.shifts.filter((element) => {
      if (element.id !== shiftId)
        return element
    });
    Vue.set(state, 'shifts', shifts);
  }
}
