import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CASH_DESCS]: ({state,commit}) => {
    HTTP.get('cashdesks').then((response)=>{
      commit(type.GET_CASH_DESCS, response.data.data)
    })
  },
  [type.GET_CASH_DESC]: ({commit, state}, cashDescId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('cashdesks/'+cashDescId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CASH_DESC]: ({state,commit}, cashDesc) => {
    HTTP.post('cashdesks', cashDesc).then((response)=>{
      commit(type.ADD_CASH_DESC, response.data)
    })
  },
  [type.UPDATE_CASH_DESC]: ({state,commit}, cashDesc) => {
    HTTP.put('cashdesks/'+cashDesc.id, cashDesc).then((response)=>{
      commit(type.UPDATE_CASH_DESC, response.data)
    })
  },
  [type.REMOVE_CASH_DESC]: ({state,commit}, cashDescId) => {
    HTTP.delete('cashdesks/'+cashDescId).then((response)=>{
      commit(type.REMOVE_CASH_DESC, response.data.id)
    })
  }
}
