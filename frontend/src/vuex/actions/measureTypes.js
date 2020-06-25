import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_MEASURE_TYPES]: ({state,commit}) => {
    HTTP.get('measuretypes').then((response)=>{
      commit(type.GET_MEASURE_TYPES, response.data)
    })
  },
  [type.GET_MEASURE_TYPE]: ({commit, state}, measureTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('measuretypes/'+measureTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_MEASURE_TYPE]: ({state,commit}, measureType) => {
    HTTP.post('measuretypes', measureType).then((response)=>{
      commit(type.ADD_MEASURE_TYPE, response.data)
    })
  },
  [type.UPDATE_MEASURE_TYPE]: ({state,commit}, measureType) => {
    HTTP.put('measuretypes/'+measureType.id, measureType).then((response)=>{
      commit(type.UPDATE_MEASURE_TYPE, response.data)
    })
  },
  [type.REMOVE_MEASURE_TYPE]: ({state,commit}, measureTypeId) => {
    HTTP.delete('measuretypes/'+measureTypeId).then((response)=>{
      commit(type.REMOVE_MEASURE_TYPE, response.data.id)
    })
  }
}
