import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CHECK_TYPES]: ({state,commit}) => {
    HTTP.get('checktypes').then((response)=>{
      commit(type.GET_CHECK_TYPES, response.data.data)
    })
  },
  [type.GET_CHECK_TYPE]: ({commit, state}, checkTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('checktypes/'+checkTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CHECK_TYPE]: ({state,commit}, checkType) => {
    HTTP.post('checktypes', checkType).then((response)=>{
      commit(type.ADD_CHECK_TYPE, response.data)
    })
  },
  [type.UPDATE_CHECK_TYPE]: ({state,commit}, checkType) => {
    HTTP.put('checktypes/'+checkType.id, checkType).then((response)=>{
      commit(type.UPDATE_CHECK_TYPE, response.data)
    })
  },
  [type.REMOVE_CHECK_TYPE]: ({state,commit}, checkTypeId) => {
    HTTP.delete('checktypes/'+checkTypeId).then((response)=>{
      commit(type.REMOVE_CHECK_TYPE, response.data.id)
    })
  }
}
