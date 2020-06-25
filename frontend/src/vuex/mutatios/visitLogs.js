import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_VISIT_LOGS]: (state, visitLogs) => {
    Vue.set(state, 'visitLogs', visitLogs)
  },
  [type.ADD_VISIT_LOG]: (state, visitLog) => {
    state.visitLogs.push(visitLog);
  },
  [type.UPDATE_VISIT_LOG]: (state, visitLog) => {
    state.visitLogs.forEach((element, index) => {
      if(element.id === visitLog.id) {
        Vue.set(state.visitLogs, index, visitLog);
      }
    });
  },
  [type.REMOVE_VISIT_LOG]: (state, visitLogId) => {
    let visitLogs = state.visitLogs.filter((element) => {
      if (element.id !== visitLogId)
        return element
    });
    Vue.set(state, 'visitLogs', visitLogs);
  }
}
