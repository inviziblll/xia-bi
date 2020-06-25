import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_DIVISIONS]: (state, divisions) => {
    Vue.set(state, 'divisions', divisions)
  },
  [type.ADD_DIVISION]: (state, division) => {
    state.divisions.push(division);
  },
  [type.UPDATE_DIVISION]: (state, division) => {
    state.divisions.forEach((element, index) => {
      if(element.id === division.id) {
        Vue.set(state.divisions, index, division);
      }
    });
  },
  [type.REMOVE_DIVISION]: (state, divisionId) => {
    let divisions = state.divisions.filter((element) => {
      if (element.id !== divisionId)
        return element
    });
    Vue.set(state, 'divisions', divisions);
  }
}
