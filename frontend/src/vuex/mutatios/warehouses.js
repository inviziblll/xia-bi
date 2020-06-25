import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_WAREHOUSES]: (state, warehouses) => {
    Vue.set(state, 'warehouses', warehouses)
  },
  [type.ADD_WAREHOUSE]: (state, warehous) => {
    state.warehouses.push(warehous);
  },
  [type.UPDATE_WAREHOUSE]: (state, warehous) => {
    state.warehouses.forEach((element, index) => {
      if(element.id === warehous.id) {
        Vue.set(state.warehouses, index, warehous);
      }
    });
  },
  [type.REMOVE_WAREHOUSE]: (state, warehousId) => {
    let warehouses = state.warehouses.filter((element) => {
      if (element.id !== warehousId)
        return element
    });
    Vue.set(state, 'warehouses', warehouses);
  }
}
