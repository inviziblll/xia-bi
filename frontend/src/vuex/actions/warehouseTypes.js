import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_WAREHOUSE_TYPES]: ({commit}) => {
    HTTP.get('warehousetypes').then((response)=>{
      commit(type.GET_WAREHOUSE_TYPES, response.data);
    })
  },
  [type.GET_WAREHOUSE_TYPE]: ({commit, state}, warehouseTypeId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('warehousetypes/'+warehouseTypeId).then((response)=>{
        resolve(Object.assign({}, response.data));
      })
    })
  },
  [type.ADD_WAREHOUSE_TYPE]: ({state,commit}, warehouseType) => {
    HTTP.post('warehousetypes', warehouseType).then((response)=>{
      commit(type.ADD_WAREHOUSE_TYPE, response.data);
    });
  },
  [type.UPDATE_WAREHOUSE_TYPE]: ({state,commit}, warehouseType) => {
    HTTP.put('warehousetypes/'+warehouseType.id, warehouseType).then((response)=>{
      commit(type.UPDATE_WAREHOUSE_TYPE, response.data);
    })
  },
  [type.REMOVE_WAREHOUSE_TYPE]: ({state,commit}, warehouseTypeId) => {
    HTTP.delete('warehousetypes/'+warehouseTypeId).then((response)=>{
      commit(type.REMOVE_WAREHOUSE_TYPE, response.data.id);
    });
  }
}
