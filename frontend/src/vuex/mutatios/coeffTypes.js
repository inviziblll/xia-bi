import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_COEFF_TYPES]: (state, coeffTypes) => {
    Vue.set(state, 'coeffTypes', coeffTypes)
  },
  [type.ADD_COEFF_TYPE]: (state, coeffType) => {
    state.coeffTypes.push(coeffType);
  },
  [type.UPDATE_COEFF_TYPE]: (state, coeffType) => {
    state.coeffTypes.forEach((element, index) => {
      if(element.id === coeffType.id) {
        Vue.set(state.coeffTypes, index, coeffType);
      }
    });
  },
  [type.REMOVE_COEFF_TYPE]: (state, coeffTypeId) => {
    let coeffTypes = state.coeffTypes.filter((element) => {
      if (element.id !== coeffTypeId)
        return element
    });
    Vue.set(state, 'coeffTypes', coeffTypes);
  }
}
