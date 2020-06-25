import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_USERS]: ({commit, state}) => {
    HTTP.get('users').then((response)=>{
      commit(type.GET_USERS, response.data)
    })
  },
  [type.GET_USER]: ({commit, state}, userId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('users/'+userId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_USER]:({commit, state}, user) => {
    HTTP.post('users', user).then((response)=>{
      commit(type.ADD_USER, response.data)
    })
  },
  [type.UPDATE_USER]:({commit, state}, user) => {
    HTTP.put('users/'+user.id, user).then((response)=>{
      commit(type.UPDATE_USER, response.data)
    })
  },
  [type.REMOVE_USER]:({commit, state}, userId) => {
    HTTP.delete('users/'+userId).then((response)=>{
      commit(type.REMOVE_USER, response.data.id)
    })
  }
}
