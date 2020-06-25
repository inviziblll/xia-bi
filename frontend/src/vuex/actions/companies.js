import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_COMPANIES]: ({state,commit}) => {
    HTTP.get('companies').then((response)=>{
      commit(type.GET_COMPANIES, response.data)
    })
  },
  [type.GET_COMPANY]: ({commit, state}, companyId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('companies/'+companyId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_COMPANY]: ({state,commit}, company) => {
    HTTP.post('companies', company).then((response)=>{
      commit(type.ADD_COMPANY, response.data)
    })
  },
  [type.UPDATE_COMPANY]: ({state,commit}, company) => {
    HTTP.put('companies/'+company.id, company).then((response)=>{
      commit(type.UPDATE_COMPANY, response.data)
    })
  },
  [type.REMOVE_COMPANY]: ({state,commit}, companyId) => {
    HTTP.delete('companies/'+companyId).then((response)=>{
      commit(type.REMOVE_COMPANY, response.data.id)
    })
  }
}
