import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_OPERATIONS]: (state, operations) => {
    Vue.set(state, 'operations', operations)
  },
  [type.ADD_OPERATION]: (state, operation) => {
    state.operations.push(operation);
  },
  [type.UPDATE_OPERATION]: (state, operation) => {
    state.operations.forEach((element, index) => {
      if(element.id === operation.id) {
        Vue.set(state.operations, index, operation);
      }
    });
  },
  [type.REMOVE_OPERATION]: (state, operationId) => {
    let operations = state.operations.filter((element) => {
      if (element.id !== operationId)
        return element
    });
    Vue.set(state, 'operations', operations);
  }
}
