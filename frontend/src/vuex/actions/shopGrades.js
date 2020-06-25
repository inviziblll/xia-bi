import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_SHOP_GRADES]: ({commit}) => {
    HTTP.get('shopgrades').then((response)=>{
      commit(type.GET_SHOP_GRADES, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data)
    })
  },
  [type.GET_SHOP_GRADE]: ({commit, state}, shopGradeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('shopgrades/'+shopGradeId).then((response)=>{
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_SHOP_GRADE]: ({state,commit}, shopGrade) => {
    HTTP.post('shopgrades', shopGrade).then((response)=>{
      commit(type.ADD_SHOP_GRADE, response.data);
    });
  },
  [type.UPDATE_SHOP_GRADE]: ({state,commit}, shopGrade) => {
    HTTP.put('shopgrades/'+shopGrade.id, shopGrade).then((response)=>{
      commit(type.UPDATE_SHOP_GRADE, response.data)
    })
  },
  [type.REMOVE_SHOP_GRADE]: ({state,commit}, shopGradeId) => {
    HTTP.delete('shopgrades/'+shopGradeId).then((response)=>{
      commit(type.REMOVE_SHOP_GRADE, response.data.id)
    });
  }
}
