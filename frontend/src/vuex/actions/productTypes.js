import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCT_TYPES]: ({state,commit}) => {
    HTTP.get('producttypes').then((response)=>{
      commit(type.GET_PRODUCT_TYPES, response.data)
    })
  },
  [type.GET_PRODUCT_TYPE]: ({commit, state}, productTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('producttypes/'+productTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_TYPE]: ({state,commit}, productType) => {
    HTTP.post('producttypes', productType).then((response)=>{
      commit(type.ADD_PRODUCT_TYPE, response.data)
    })
  },
  [type.UPDATE_PRODUCT_TYPE]: ({state,commit}, productType) => {
    HTTP.put('producttypes/'+productType.id, productType).then((response)=>{
      commit(type.UPDATE_PRODUCT_TYPE, response.data)
    })
  },
  [type.REMOVE_PRODUCT_TYPE]: ({state,commit}, productTypeId) => {
    HTTP.delete('producttypes/'+productTypeId).then((response)=>{
      commit(type.REMOVE_PRODUCT_TYPE, response.data.id)
    })
  }
}
