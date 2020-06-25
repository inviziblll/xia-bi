import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_SHIFTS]: ({state,commit}) => {
    HTTP.get('shifts').then((response)=>{
      commit(type.GET_SHIFTS, response.data)
    })
  },
  [type.GET_SHIFT]: ({commit, state}, shiftId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('shifts/'+shiftId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_SHIFT]: ({state,commit}, shift) => {
    HTTP.post('shifts', shift).then((response)=>{
      commit(type.ADD_SHIFT, response.data)
    })
  },
  [type.UPDATE_SHIFT]: ({state,commit}, shift) => {
    HTTP.put('shifts/'+shift.id, shift).then((response)=>{
      commit(type.UPDATE_SHIFT, response.data)
    })
  },
  [type.REMOVE_SHIFT]: ({state,commit}, shiftId) => {
    HTTP.delete('shifts/'+shiftId).then((response)=>{
      commit(type.REMOVE_SHIFT, response.data.id)
    })
  }
}
