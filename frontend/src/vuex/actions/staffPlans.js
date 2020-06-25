import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_STAFF_PLANS]: ({commit, state}) => {
    HTTP.get('staffplans').then((response)=>{
      commit(type.GET_STAFF_PLANS, response.data)
    })
  },
  [type.GET_STAFF_PLANS_PAGINATE]: ({commit, state}, {sortBy, descending, page, rowsPerPage}) => {
    HTTP.get(
    `getstaffplans/?page=${page}&sortBy=${sortBy}&descending=${descending}&rowsPerPage=${rowsPerPage}`
    ).then((response)=>{
      commit(type.GET_STAFF_PLANS_PAGINATE, response.data)
    })
  },
  [type.GET_STAFF_PLAN]: ({commit, state}, staffPlanId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('staffplans/'+staffPlanId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_STAFF_PLAN]:({commit, state}, staffPlan) => {
    HTTP.post('staffplans', staffPlan).then((response)=>{
      commit(type.ADD_STAFF_PLAN, response.data)
    })
  },
  [type.UPDATE_STAFF_PLAN]:({commit, state}, staffPlan) => {
    HTTP.put('staffplans/'+staffPlan.id, staffPlan).then((response)=>{
      commit(type.UPDATE_STAFF_PLAN, response.data)
    })
  },
  [type.REMOVE_STAFF_PLAN]:({commit, state}, staffPlanId) => {
    HTTP.delete('staffplans/'+staffPlanId).then((response)=>{
      commit(type.REMOVE_STAFF_PLAN, response.data.id)
    })
  }
}
