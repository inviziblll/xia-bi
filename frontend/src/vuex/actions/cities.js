import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CITIES]: ({commit}) => {
    HTTP.get('cities').then((response)=>{
      commit(type.GET_CITIES, response.data)
    })
  },
  [type.GET_CITY]: ({commit, state}, cityId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('cities/'+cityId).then((response)=>{
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_CITY]: ({state,commit}, city) => {
    HTTP.post('cities', city).then((response)=>{
      commit(type.ADD_CITY, response.data);
    });
  },
  [type.UPDATE_CITY]: ({state,commit}, city) => {
    HTTP.put('cities/'+city.id, city).then((response)=>{
      commit(type.UPDATE_CITY, response.data)
    })
  },
  [type.REMOVE_CITY]: ({state,commit}, cityId) => {
    HTTP.delete('cities/'+cityId).then((response)=>{
      commit(type.REMOVE_CITY, response.data.id)
    });
  }
}
