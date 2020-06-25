import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_DIVISIONS]: ({state,commit}) => {
    HTTP.get('divisions').then((response)=>{
      commit(type.GET_DIVISIONS, response.data)
    })
  },
  [type.GET_DIVISION]: ({commit, state}, divisionId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('divisions/'+divisionId).then((response)=>{
        // resolve(Object.assign({}, response.data.body, {user: state.users.find((user) => user.id == response.data.body.user_id)}));
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_DIVISION]: ({state,commit}, division) => {
    HTTP.post('divisions', division).then((response)=>{
      commit(type.ADD_DIVISION, response.data);
    });
  },
  [type.UPDATE_DIVISION]: ({state,commit}, division) => {
    HTTP.put('divisions/'+division.id, division).then((response)=>{
      commit(type.UPDATE_DIVISION, response.data)
    })
  },
  [type.REMOVE_DIVISION]: ({state,commit}, divisionId) => {
    HTTP.delete('divisions/'+divisionId).then((response)=>{
      commit(type.REMOVE_DIVISION, response.data.id)
    });
  }
}
