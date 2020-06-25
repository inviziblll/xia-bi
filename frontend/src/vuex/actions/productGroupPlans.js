import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_PRODUCT_GROUP_PLANS]: ({state,commit}) => {
    HTTP.get('productgroupplans').then((response)=>{
      commit(type.GET_PRODUCT_GROUP_PLANS, response.data)
    })
  },
  [type.GET_PRODUCT_GROUP_PLAN]: ({commit, state}, productGroupPlanId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('productgroupplans/'+productGroupPlanId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_GROUP_PLAN]: ({state,commit}, productGroupPlan) => {
    HTTP.post('productgroupplans', productGroupPlan).then((response)=>{
      commit(type.ADD_PRODUCT_GROUP_PLAN, response.data)
    })
  },
  [type.UPDATE_PRODUCT_GROUP_PLAN]: ({state,commit}, productGroupPlan) => {
    HTTP.put('productgroupplans/'+productGroupPlan.id, productGroupPlan).then((response)=>{
      commit(type.UPDATE_PRODUCT_GROUP_PLAN, response.data)
    })
  },
  [type.REMOVE_PRODUCT_GROUP_PLAN]: ({state,commit}, productGroupPlanId) => {
    HTTP.delete('productgroupplans/'+productGroupPlanId).then((response)=>{
      commit(type.REMOVE_PRODUCT_GROUP_PLAN, response.data.id)
    })
  }
}
