import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_COEFF_TYPES]: ({state,commit}) => {
    HTTP.get('coefftypes').then((response)=>{
      commit(type.GET_COEFF_TYPES, response.data)
    })
  },
  [type.GET_COEFF_TYPE]: ({commit, state}, coeffTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('coefftypes/'+coeffTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_COEFF_TYPE]: ({state,commit}, coeffType) => {
    HTTP.post('coefftypes', coeffType).then((response)=>{
      commit(type.ADD_COEFF_TYPE, response.data)
    })
  },
  [type.UPDATE_COEFF_TYPE]: ({state,commit}, coeffType) => {
    HTTP.put('coefftypes/'+coeffType.id, coeffType).then((response)=>{
      commit(type.UPDATE_COEFF_TYPE, response.data)
    })
  },
  [type.REMOVE_COEFF_TYPE]: ({state,commit}, coeffTypeId) => {
    HTTP.delete('coefftypes/'+coeffTypeId).then((response)=>{
      commit(type.REMOVE_COEFF_TYPE, response.data.id)
    })
  }
}
