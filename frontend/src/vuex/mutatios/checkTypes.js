import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CHECK_TYPES]: (state, checkTypes) => {
    Vue.set(state, 'checkTypes', checkTypes)
  },
  [type.ADD_CHECK_TYPE]: (state, checkType) => {
    state.checkTypes.push(checkType);
  },
  [type.UPDATE_CHECK_TYPE]: (state, checkType) => {
    state.checkTypes.forEach((element, index) => {
      if(element.id === checkType.id) {
        Vue.set(state.checkTypes, index, checkType);
      }
    });
  },
  [type.REMOVE_CHECK_TYPE]: (state, checkTypeId) => {
    let checkTypes = state.checkTypes.filter((element) => {
      if (element.id !== checkTypeId)
        return element
    });
    Vue.set(state, 'checkTypes', checkTypes);
  }
}
