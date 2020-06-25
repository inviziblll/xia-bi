import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCT_GROUPS]: ({state,commit}) => {
    HTTP.get('productgroups').then((response)=>{
      commit(type.GET_PRODUCT_GROUPS, response.data)
    })
  },
  [type.GET_PRODUCT_GROUP]: ({commit, state}, productGroupId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('productgroups/'+productGroupId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_GROUP]: ({state,commit}, productGroup) => {
    HTTP.post('productgroups', productGroup).then((response)=>{
      commit(type.ADD_PRODUCT_GROUP, response.data)
    })
  },
  [type.UPDATE_PRODUCT_GROUP]: ({state,commit}, productGroup) => {
    HTTP.put('productgroups/'+productGroup.id, productGroup).then((response)=>{
      commit(type.UPDATE_PRODUCT_GROUP, response.data)
    })
  },
  [type.REMOVE_PRODUCT_GROUP]: ({state,commit}, productGroupId) => {
    HTTP.delete('productgroups/'+productGroupId).then((response)=>{
      commit(type.REMOVE_PRODUCT_GROUP, response.data.id)
    })
  }
}
