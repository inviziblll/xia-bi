import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_SHOP_SHIFTS]: ({state,commit}) => {
    HTTP.get('shopshifts').then((response)=>{
      commit(type.GET_SHOP_SHIFTS, response.data)
    })
  },
  [type.GET_SHOP_SHIFT_PAGINATE]: ({commit, state}, {sortBy, descending, page, rowsPerPage, searchText}) => {
    HTTP.get(
      `getShopShifts/?page=${page}
      &sortBy=${sortBy}
      &descending=${descending}
      &rowsPerPage=${rowsPerPage}
      &searchText=${searchText}`
    ).then((response)=>{
      commit(type.GET_SHOP_SHIFT_PAGINATE, response.data)
    })
  },
  [type.GET_SHOP_SHIFT]: ({commit, state}, shopShiftId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('shopshifts/'+shopShiftId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_SHOP_SHIFT]: ({state,commit}, shopShift) => {
    let findShopShift = state.shopShifts.some((shopShiftEl) => {
      return shopShiftEl.date === shopShift.date
        && shopShiftEl.user_id === shopShift.user_id
        && shopShiftEl.role_id === shopShift.role_id
        && shopShiftEl.shop_id === shopShift.shop_id
        && shopShiftEl.shift_id === shopShift.shift_id
    });

    if(!findShopShift){
      HTTP.post('shopshifts', shopShift).then((response)=>{
        commit(type.ADD_SHOP_SHIFT, response.data)
      })
    }else{
      commit(type.NOTIFICATION, {type: 'warning', text: "Данная смена существует!!!"})
    }
  },
  [type.UPDATE_SHOP_SHIFT]: ({state,commit}, shopShift) => {

    let findShopShift = state.shopShifts.some((shopShiftEl) => {
      return shopShiftEl.date === shopShift.date
        && shopShiftEl.user_id === shopShift.user_id
        && shopShiftEl.role_id === shopShift.role_id
        && shopShiftEl.shop_id === shopShift.shop_id
        && shopShiftEl.shift_id === shopShift.shift_id
    });
    if(!findShopShift) {
      HTTP.put('shopshifts/'+shopShift.id, shopShift).then((response)=>{
        commit(type.UPDATE_SHOP_SHIFT, response.data)
      })
    }else{
      commit(type.NOTIFICATION, {type: 'warning', text: "Данная смена существует!!!"})
    }
  },
  [type.REMOVE_SHOP_SHIFT]: ({state,commit}, shopShiftId) => {
    HTTP.delete('shopshifts/'+shopShiftId).then((response)=>{
      commit(type.REMOVE_SHOP_SHIFT, response.data.id)
    })
  }
}
