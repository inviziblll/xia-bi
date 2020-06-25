import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CITIES]: (state, cities) => {
    Vue.set(state, 'cities', cities)
  },
  [type.ADD_CITY]: (state, city) => {
    state.cities.push(city);
  },
  [type.UPDATE_CITY]: (state, city) => {
    state.cities.forEach((element, index) => {
      if(element.id === city.id) {
        Vue.set(state.cities, index, city);
      }
    });
  },
  [type.REMOVE_CITY]: (state, cityId) => {
    let cities = state.cities.filter((element) => {
      if (element.id !== cityId)
        return element
    });
    Vue.set(state, 'cities', cities);
  }
}
