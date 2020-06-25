import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CHECK_DETAILS]: (state, checkDetails) => {
    Vue.set(state, 'checkDetails', checkDetails)
  },
  [type.ADD_CHECK_DETAIL]: (state, checkDetail) => {
    state.checkDetails.push(checkDetail);
  },
  [type.UPDATE_CHECK_DETAIL]: (state, checkDetail) => {
    state.checkDetails.forEach((element, index) => {
      if(element.id === checkDetail.id) {
        Vue.set(state.checkDetails, index, checkDetail);
      }
    });
  },
  [type.REMOVE_CHECK_DETAIL]: (state, checkDetailId) => {
    let checkDetails = state.checkDetails.filter((element) => {
      if (element.id !== checkDetailId)
        return element
    });
    Vue.set(state, 'checkDetails', checkDetails);
  }
}
