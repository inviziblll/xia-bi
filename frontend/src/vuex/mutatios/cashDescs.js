import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CASH_DESCS]: (state, cashDescs) => {
    Vue.set(state, 'cashDescs', cashDescs)
  },
  [type.ADD_CASH_DESC]: (state, cashDesc) => {
    state.cashDescs.push(cashDesc);
  },
  [type.UPDATE_CASH_DESC]: (state, cashDesc) => {
    state.cashDescs.forEach((element, index) => {
      if(element.id === cashDesc.id) {
        Vue.set(state.cashDescs, index, cashDesc);
      }
    });
  },
  [type.REMOVE_CASH_DESC]: (state, cashDescId) => {
    let cashDescs = state.cashDescs.filter((element) => {
      if (element.id !== cashDescId)
        return element
    });
    Vue.set(state, 'cashDescs', cashDescs);
  }
}
