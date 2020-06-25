import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_OPERATIONS]: ({commit}) => {
    HTTP.get('operations').then((response)=>{
      commit(type.GET_OPERATIONS, response.data)
    })
  },
  [type.GET_OPERATION]: ({commit, state}, operationId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('operations/'+operationId).then((response)=>{
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_OPERATION]: ({state,commit}, operation) => {
    HTTP.post('operations', operation).then((response)=>{
      commit(type.ADD_OPERATION, response.data);
    });
  },
  [type.UPDATE_OPERATION]: ({state,commit}, operation) => {
    HTTP.put('operations/'+operation.id, operation).then((response)=>{
      commit(type.UPDATE_OPERATION, response.data)
    })
  },
  [type.REMOVE_OPERATION]: ({state,commit}, operationId) => {
    HTTP.delete('operations/'+operationId).then((response)=>{
      commit(type.REMOVE_OPERATION, response.data.id)
    });
  }
}
