import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_SHOPS]: ({state,commit}) => {
    HTTP.get('shops').then((response)=>{
      commit(type.GET_SHOPS, response.data)
    })
  },
  [type.GET_SHOP]: ({commit, state}, shopId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('shops/'+shopId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_SHOP]: ({state,commit}, shop) => {
    HTTP.post('shops', shop).then((response)=>{
      commit(type.ADD_SHOP, response.data)
    })
  },
  [type.UPDATE_SHOP]: ({state,commit}, shop) => {
    HTTP.put('shops/'+shop.id, shop).then((response)=>{
      commit(type.UPDATE_SHOP, response.data)
    })
  },
  [type.REMOVE_SHOP]: ({state,commit}, shopId) => {
    HTTP.delete('shops/'+shopId).then((response)=>{
      commit(type.REMOVE_SHOP, response.data.id)
    })
  }
}
