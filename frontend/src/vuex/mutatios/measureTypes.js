import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_MEASURE_TYPES]: (state, measureTypes) => {
    Vue.set(state, 'measureTypes', measureTypes)
  },
  [type.ADD_MEASURE_TYPE]: (state, measureType) => {
    state.measureTypes.push(measureType);
  },
  [type.UPDATE_MEASURE_TYPE]: (state, measureType) => {
    state.measureTypes.forEach((element, index) => {
      if(element.id === measureType.id) {
        Vue.set(state.measureTypes, index, measureType);
      }
    });
  },
  [type.REMOVE_MEASURE_TYPE]: (state, measureTypeId) => {
    let measureTypes = state.measureTypes.filter((element) => {
      if (element.id !== measureTypeId)
        return element
    });
    Vue.set(state, 'measureTypes', measureTypes);
  }
}
