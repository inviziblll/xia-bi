import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_WAREHOUSE_TYPES]: (state, warehouseTypes) => {
    Vue.set(state, 'warehouseTypes', warehouseTypes)
  },
  [type.ADD_WAREHOUSE_TYPE]: (state, warehouseType) => {
    state.warehouseTypes.push(warehouseType);
  },
  [type.UPDATE_WAREHOUSE_TYPE]: (state, warehouseType) => {
    state.warehouseTypes.forEach((element, index) => {
      if(element.id === warehouseType.id) {
        Vue.set(state.warehouseTypes, index, warehouseType);
      }
    });
  },
  [type.REMOVE_WAREHOUSE_TYPE]: (state, warehouseTypeId) => {
    let warehouseTypes = state.warehouseTypes.filter((element) => {
      if (element.id !== warehouseTypeId)
        return element
    });
    Vue.set(state, 'warehouseTypes', warehouseTypes);
  }
}
