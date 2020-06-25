import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_REGIONS]: ({state,commit}) => {
    HTTP.get('regions').then((response)=>{
      commit(type.GET_REGIONS, response.data)
    })
  },
  [type.GET_REGION]: ({commit, state}, regionId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('regions/'+regionId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_REGION]: ({state,commit}, region) => {
    HTTP.post('regions', region).then((response)=>{
      commit(type.ADD_REGION, response.data)
    })
  },
  [type.UPDATE_REGION]: ({state,commit}, region) => {
    HTTP.put('regions/'+region.id, region).then((response)=>{
      commit(type.UPDATE_REGION, response.data)
    })
  },
  [type.REMOVE_REGION]: ({state,commit}, regionId) => {
    HTTP.delete('regions/'+regionId).then((response)=>{
      commit(type.REMOVE_REGION, response.data.id)
    })
  }
}
