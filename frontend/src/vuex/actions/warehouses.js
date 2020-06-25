import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_WAREHOUSES]: ({state,commit}) => {
    HTTP.get('warehouses').then((response)=>{
      commit(type.GET_WAREHOUSES, response.data)
    })
  },
  [type.GET_WAREHOUSE]: ({commit, state}, warehouseId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('warehouses/'+warehouseId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_WAREHOUSE]: ({state,commit}, warehouse) => {
    HTTP.post('warehouses', warehouse).then((response)=>{
      commit(type.ADD_WAREHOUSE, response.data)
    })
  },
  [type.UPDATE_WAREHOUSE]: ({state,commit}, warehouse) => {
    HTTP.put('warehouses/'+warehouse.id, warehouse).then((response)=>{
      commit(type.UPDATE_WAREHOUSE, response.data)
    })
  },
  [type.REMOVE_WAREHOUSE]: ({state,commit}, warehouseId) => {
    HTTP.delete('warehouses/'+warehouseId).then((response)=>{
      commit(type.REMOVE_WAREHOUSE, response.data.id)
    })
  }
}
