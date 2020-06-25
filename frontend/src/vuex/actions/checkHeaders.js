import * as type from "../types";
import HTTP from "../../axios";

export default {
  [type.GET_CHECK_HEADERS]: ({state,commit}, {page, search}) => {
    HTTP.get('checkheaders?page='+page).then((response)=>{
      commit(type.GET_CHECK_HEADERS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data)
    })
  },
  [type.GET_CHECK_HEADER]: ({commit, state}, checkHeaderId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('checkheaders/'+checkHeaderId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.GET_CHECK_HEADER_DETAIL]: ({commit, state}, checkHeaderId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('checkheaders/'+checkHeaderId).then((response)=>{
        commit(type.GET_CHECK_HEADER_DETAIL, response.data);
      })
    })
  },
  [type.ADD_CHECK_HEADER]: ({commit,dispatch}, {checkHeader, details}) => {
    HTTP.post('checkheaders', checkHeader).then((response)=>{
      commit(type.ADD_CHECK_HEADER, response.data);
      details.forEach(element => {
        if(element.product_id !== null && element.user_id !== null){
          element.check_header_id = response.data.id;
          element.amount = (element.price * element.count).toString();
          dispatch(type.ADD_CHECK_DETAIL, element);
        }
      });
      checkHeader.discounts.forEach(element => {
        const discount = {
          check_header_id: response.data.id,
          discount_id: element.id
        };
        HTTP.post('/adddiscounttocheckheader/'+response.data.id, discount)
      });
    })
  },
  [type.UPDATE_CHECK_HEADER]: ({commit,dispatch}, {checkHeader, details}) => {
    HTTP.put('checkheaders/'+checkHeader.id, checkHeader).then((response)=>{
      commit(type.UPDATE_CHECK_HEADER, response.data);

      details.forEach(element => {
        if(element.product_id !== null && element.user_id !== null) {
          element.check_header_id = response.data.id;
          element.amount = (element.price * element.count).toString();
          if (element.id) {
            dispatch(type.UPDATE_CHECK_DETAIL, element);
          } else {
            dispatch(type.ADD_CHECK_DETAIL, element);
          }
        }
      });
      checkHeader.discounts.forEach(element => {
        const discount = {
          check_header_id: response.data.id,
          discount_id: element.id
        };
        HTTP.post('/adddiscounttocheckheader/'+response.data.id, discount)
      });
    })
  },
  [type.REMOVE_CHECK_HEADER]: ({state,commit}, checkHeaderId) => {
    HTTP.delete('checkheaders/'+checkHeaderId).then((response)=>{
      commit(type.REMOVE_CHECK_HEADER, response.data.id)
    })
  }
}
