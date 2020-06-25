import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_REGIONS]: (state, regions) => {
    Vue.set(state, 'regions', regions)
  },
  [type.ADD_REGION]: (state, region) => {
    state.regions.push(region);
  },
  [type.UPDATE_REGION]: (state, region) => {
    state.regions.forEach((element, index) => {
      if(element.id === region.id) {
        Vue.set(state.regions, index, region);
      }
    });
  },
  [type.REMOVE_REGION]: (state, regionId) => {
    let regions = state.regions.filter((element) => {
      if (element.id !== regionId)
        return element
    });
    Vue.set(state, 'regions', regions);
  }
}
