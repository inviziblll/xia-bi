import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_DISCOUNTS]: ({state,commit}, page) => {
    HTTP.get('discounts?page='+page).then((response)=>{
      commit(type.GET_DISCOUNTS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data)
    })
  },
  [type.GET_DISCOUNTS_LIST]: ({state,commit}) => {
    HTTP.get('discounts').then((response)=>{
      commit(type.GET_DISCOUNTS, response.data.data);
    })
  },
  [type.GET_DISCOUNT]: ({commit, state}, discountId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('discounts/'+discountId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_DISCOUNT]: ({state,commit}, discount) => {
    HTTP.post('discounts', discount).then((response)=>{
      commit(type.ADD_DISCOUNT, response.data)
    })
  },
  [type.UPDATE_DISCOUNT]: ({state,commit}, discount) => {
    HTTP.put('discounts/'+discount.id, discount).then((response)=>{
      commit(type.UPDATE_DISCOUNT, response.data)
    })
  },
  [type.REMOVE_DISCOUNT]: ({state,commit}, discountId) => {
    HTTP.delete('discounts/'+discountId).then((response)=>{
      commit(type.REMOVE_DISCOUNT, response.data.id)
    })
  }
}
