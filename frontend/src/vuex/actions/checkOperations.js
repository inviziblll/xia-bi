import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CHECK_OPERATIONS]: ({state,commit}) => {
    HTTP.get('checkoperations').then((response)=>{
      commit(type.GET_CHECK_OPERATIONS, response.data.data)
    })
  },
  [type.GET_CHECK_OPERATION]: ({commit, state}, checkOperationId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('checkoperations/'+checkOperationId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CHECK_OPERATION]: ({state,commit}, checkOperation) => {
    HTTP.post('checkoperations', checkOperation).then((response)=>{
      commit(type.ADD_CHECK_OPERATION, response.data)
    })
  },
  [type.UPDATE_CHECK_OPERATION]: ({state,commit}, checkOperation) => {
    HTTP.put('checkoperations/'+checkOperation.id, checkOperation).then((response)=>{
      commit(type.UPDATE_CHECK_OPERATION, response.data)
    })
  },
  [type.REMOVE_CHECK_OPERATION]: ({state,commit}, checkOperationId) => {
    HTTP.delete('checkoperations/'+checkOperationId).then((response)=>{
      commit(type.REMOVE_CHECK_OPERATION, response.data.id)
    })
  }
}
