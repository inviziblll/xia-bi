import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CHECK_HEADERS]: (state, checkHeaders) => {
    Vue.set(state, 'checkHeaders', checkHeaders)
  },
  [type.GET_CHECK_HEADER_DETAIL]: (state, checkHeader) => {
    Vue.set(state, 'checkHeader', checkHeader)
  },
  [type.ADD_CHECK_HEADER]: (state, checkHeader) => {
    state.checkHeaders.push(checkHeader);
  },
  [type.UPDATE_CHECK_HEADER]: (state, checkHeader) => {
    state.checkHeaders.forEach((element, index) => {
      if(element.id === checkHeader.id) {
        Vue.set(state.checkHeaders, index, checkHeader);
      }
    });
  },
  [type.REMOVE_CHECK_HEADER]: (state, checkHeaderId) => {
    let checkHeaders = state.checkHeaders.filter((element) => {
      if (element.id !== checkHeaderId)
        return element
    });
    Vue.set(state, 'checkHeaders', checkHeaders);
  }
}
