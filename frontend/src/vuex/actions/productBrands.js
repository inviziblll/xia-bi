import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCT_BRANDS]: ({state,commit}) => {
    HTTP.get('productbrands').then((response)=>{
      commit(type.GET_PRODUCT_BRANDS, response.data)
    })
  },
  [type.GET_PRODUCT_BRAND]: ({commit, state}, productBrandId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('productbrands/'+productBrandId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_BRAND]: ({state,commit}, productBrand) => {
    HTTP.post('productbrands', productBrand).then((response)=>{
      commit(type.ADD_PRODUCT_BRAND, response.data)
    })
  },
  [type.UPDATE_PRODUCT_BRAND]: ({state,commit}, productBrand) => {
    HTTP.put('productbrands/'+productBrand.id, productBrand).then((response)=>{
      commit(type.UPDATE_PRODUCT_BRAND, response.data)
    })
  },
  [type.REMOVE_PRODUCT_BRAND]: ({state,commit}, productBrandId) => {
    HTTP.delete('productbrands/'+productBrandId).then((response)=>{
      commit(type.REMOVE_PRODUCT_BRAND, response.data.id)
    })
  }
}
