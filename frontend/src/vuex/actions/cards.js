import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CARDS]: ({state,commit}, {page}) => {
    HTTP.get('cards?page='+page).then((response)=>{
      commit(type.GET_CARDS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data);
    })
  },
  [type.GET_CARD]: ({commit, state}, cardId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('cards/'+cardId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_CARD]: ({state,commit}, card) => {
    HTTP.post('cards', card).then((response)=>{
      commit(type.ADD_CARD, response.data)
    })
  },
  [type.UPDATE_CARD]: ({state,commit}, card) => {
    HTTP.put('cards/'+card.id, card).then((response)=>{
      commit(type.UPDATE_CARD, response.data)
    })
  },
  [type.REMOVE_CARD]: ({state,commit}, cardId) => {
    HTTP.delete('cards/'+cardId).then((response)=>{
      commit(type.REMOVE_CARD, response.data.id)
    })
  }
}
