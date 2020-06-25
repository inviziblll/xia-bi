import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CLIENTS]: ({state,commit}, {page}) => {
    HTTP.get('clients?page='+page).then((response)=>{
      commit(type.GET_CLIENTS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data);
    })
  },
  [type.FETCH_CLIENTS]: ({state,commit}) => {
    //@TODO Доделать поиск из селекта в компоненте CARDS
    HTTP.get('clients').then((response)=>{
      commit(type.GET_CLIENTS, response.data.data);
    })
  },
  [type.GET_CLIENT]: ({commit, state}, clientId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('clients/'+clientId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CLIENT]: ({state,commit}, client) => {
    HTTP.post('clients', client).then((response)=>{
      commit(type.ADD_CLIENT, response.data)
    })
  },
  [type.UPDATE_CLIENT]: ({state,commit}, client) => {
    HTTP.put('clients/'+client.id, client).then((response)=>{
      commit(type.UPDATE_CLIENT, response.data)
    })
  },
  [type.REMOVE_CLIENT]: ({state,commit}, clientId) => {
    HTTP.delete('clients/'+clientId).then((response)=>{
      commit(type.REMOVE_CLIENT, response.data.id)
    })
  }
}
