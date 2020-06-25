import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CHECK_OPERATIONS]: (state, checkOperations) => {
    Vue.set(state, 'checkOperations', checkOperations)
  },
  [type.ADD_CHECK_OPERATION]: (state, checkOperation) => {
    state.checkOperations.push(checkOperation);
  },
  [type.UPDATE_CHECK_OPERATION]: (state, checkOperation) => {
    state.checkOperations.forEach((element, index) => {
      if(element.id === checkOperation.id) {
        Vue.set(state.checkOperations, index, checkOperation);
      }
    });
  },
  [type.REMOVE_CHECK_OPERATION]: (state, checkOperationId) => {
    let checkOperations = state.checkOperations.filter((element) => {
      if (element.id !== checkOperationId)
        return element
    });
    Vue.set(state, 'checkOperations', checkOperations);
  }
}
