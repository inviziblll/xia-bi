import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_ROLES]: ({state,commit}) => {
    HTTP.get('roles').then((response)=>{
      commit(type.GET_ROLES, response.data)
    })
  },
  [type.GET_ROLE]: ({commit, state}, roleId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('roles/'+roleId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_ROLE]: ({state,commit}, role) => {
    HTTP.post('roles', role).then((response)=>{
      commit(type.ADD_ROLE, response.data)
    })
  },
  [type.UPDATE_ROLE]: ({state,commit}, role) => {
    HTTP.put('roles/'+role.id, role).then((response)=>{
      commit(type.UPDATE_ROLE, response.data)
    })
  },
  [type.REMOVE_ROLE]: ({state,commit}, roleId) => {
    HTTP.delete('roles/'+roleId).then((response)=>{
      commit(type.REMOVE_ROLE, response.data.id)
    })
  }
}
