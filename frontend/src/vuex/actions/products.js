import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCTS]: ({state,commit}) => {
    HTTP.get('products').then((response)=>{
      commit(type.GET_PRODUCTS, response.data)
    })
  },
  [type.GET_PRODUCT]: ({commit, state}, productId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('products/'+productId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT]: ({state,commit}, product) => {
    HTTP.post('products', product).then((response)=>{
      commit(type.ADD_PRODUCT, response.data)
    })
  },
  [type.UPDATE_PRODUCT]: ({state,commit}, product) => {
    HTTP.put('products/'+product.id, product).then((response)=>{
      commit(type.UPDATE_PRODUCT, response.data)
    })
  },
  [type.REMOVE_PRODUCT]: ({state,commit}, productId) => {
    HTTP.delete('products/'+productId).then((response)=>{
      commit(type.REMOVE_PRODUCT, response.data.id)
    })
  }
}
