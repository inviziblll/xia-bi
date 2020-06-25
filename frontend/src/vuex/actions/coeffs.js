import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_COEFFS]: ({commit}) => {
    HTTP.get('coeffs').then((response)=>{
      commit(type.GET_COEFFS, response.data)
    })
  },
  [type.GET_COEFF]: ({commit, state}, coeffId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('coeffs/'+coeffId).then((response)=>{
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_COEFF]: ({state,commit}, coeff) => {
    HTTP.post('coeffs', coeff).then((response)=>{
      commit(type.ADD_COEFF, response.data);
    });
  },
  [type.UPDATE_COEFF]: ({state,commit}, coeff) => {
    HTTP.put('coeffs/'+coeff.id, coeff).then((response)=>{
      commit(type.UPDATE_COEFF, response.data)
    })
  },
  [type.REMOVE_COEFF]: ({state,commit}, coeffId) => {
    HTTP.delete('coeffs/'+coeffId).then((response)=>{
      commit(type.REMOVE_COEFF, response.data.id)
    });
  }
}
