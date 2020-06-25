import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCT_GROUP_PLAN_TYPES]: ({state,commit}) => {
    HTTP.get('productgroupplantypes').then((response)=>{
      commit(type.GET_PRODUCT_GROUP_PLAN_TYPES, response.data)
    })
  },
  [type.GET_PRODUCT_GROUP_PLAN_TYPE]: ({commit, state}, productGroupPlanTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('productgroupplantypes/'+productGroupPlanTypeId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_GROUP_PLAN_TYPE]: ({state,commit}, productGroupPlanType) => {
    HTTP.post('productgroupplantypes', productGroupPlanType).then((response)=>{
      commit(type.ADD_PRODUCT_GROUP_PLAN_TYPE, response.data)
    })
  },
  [type.UPDATE_PRODUCT_GROUP_PLAN_TYPE]: ({state,commit}, productGroupPlanType) => {
    HTTP.put('productgroupplantypes/'+productGroupPlanType.id, productGroupPlanType).then((response)=>{
      commit(type.UPDATE_PRODUCT_GROUP_PLAN_TYPE, response.data)
    })
  },
  [type.REMOVE_PRODUCT_GROUP_PLAN_TYPE]: ({state,commit}, productGroupPlanTypeId) => {
    HTTP.delete('productgroupplantypes/'+productGroupPlanTypeId).then((response)=>{
      commit(type.REMOVE_PRODUCT_GROUP_PLAN_TYPE, response.data.id)
    })
  }
}
