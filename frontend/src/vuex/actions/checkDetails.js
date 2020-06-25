import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CHECK_DETAILS]: ({state,commit}, checkHeaderId) => {
    return new Promise((resolve, reject) => {
      if (checkHeaderId === null){
        resolve([]);
      }else{
        HTTP.get(`checkdetailheader/${checkHeaderId}`).then((response)=>{
          resolve(response.data);
        })
      }
    });
  },
  [type.GET_CHECK_DETAIL]: ({commit, state}, checkDetailId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('checkdetails/'+checkDetailId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CHECK_DETAIL]: ({state,commit}, checkDetail) => {
    HTTP.post('checkdetails', checkDetail).then((response)=>{
      commit(type.ADD_CHECK_DETAIL, response.data)
    })
  },
  [type.UPDATE_CHECK_DETAIL]: ({state,commit}, checkDetail) => {
    HTTP.put('checkdetails/'+checkDetail.id, checkDetail).then((response)=>{
      commit(type.UPDATE_CHECK_DETAIL, response.data)
    })
  },
  [type.REMOVE_CHECK_DETAIL]: ({state,commit}, checkDetailId) => {
    HTTP.delete('checkdetails/'+checkDetailId).then((response)=>{
      commit(type.REMOVE_CHECK_DETAIL, response.data.id)
    })
  }
}
