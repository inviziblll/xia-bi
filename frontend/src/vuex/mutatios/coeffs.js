import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_COEFFS]: (state, coeffs) => {
    Vue.set(state, 'coeffs', coeffs)
  },
  [type.ADD_COEFF]: (state, coeff) => {
    state.coeffs.push(coeff);
  },
  [type.UPDATE_COEFF]: (state, coeff) => {
    state.coeffs.forEach((element, index) => {
      if(element.id === coeff.id) {
        Vue.set(state.coeffs, index, coeff);
      }
    });
  },
  [type.REMOVE_COEFF]: (state, coeffId) => {
    let coeffs = state.coeffs.filter((element) => {
      if (element.id !== coeffId)
        return element
    });
    Vue.set(state, 'coeffs', coeffs);
  }
}
