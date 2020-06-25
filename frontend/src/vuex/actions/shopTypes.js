import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_SHOP_TYPES]: ({state,commit}) => {
    HTTP.get('shoptypes').then((response)=>{
      commit(type.GET_SHOP_TYPES, response.data)
    })
  },
  [type.GET_SHOP_TYPE]: ({commit, state}, shopTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('shoptypes/'+shopTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_SHOP_TYPE]: ({state,commit}, shopType) => {
    HTTP.post('shoptypes', shopType).then((response)=>{
      commit(type.ADD_SHOP_TYPE, response.data)
    })
  },
  [type.UPDATE_SHOP_TYPE]: ({state,commit}, shopType) => {
    HTTP.put('shoptypes/'+shopType.id, shopType).then((response)=>{
      commit(type.UPDATE_SHOP_TYPE, response.data)
    })
  },
  [type.REMOVE_SHOP_TYPE]: ({state,commit}, shopTypeId) => {
    HTTP.delete('shoptypes/'+shopTypeId).then((response)=>{
      commit(type.REMOVE_SHOP_TYPE, response.data.id)
    })
  }
}
