import * as type from "../types";
import HTTP from "../../axios";
import Vue from "vue";

export default {
  [type.GET_PRODUCT_REMAINS]: ({state,commit}, {page, search}) => {
    let urlSearch = '';
    if(typeof search === 'object'){
      urlSearch = Vue.urlSerialize(search);
      if(urlSearch !== ''){
        urlSearch = '&'+urlSearch;
      }
    }
    HTTP.get('productremains?page='+page+urlSearch).then((response)=>{
      commit(type.GET_PRODUCT_REMAINS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data)
    }).catch((error) => {
      commit(type.NOTIFICATION, {type: 'error', text: "По данным фильтрам, остатков не найдено!!!"})
    })
  },
  [type.GET_PRODUCT_REMAIN]: ({commit, state}, productRemainId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('productremains/'+productRemainId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_PRODUCT_REMAIN]: ({state,commit}, productRemain) => {
    HTTP.post('productremains', productRemain).then((response)=>{
      commit(type.ADD_PRODUCT_REMAIN, response.data)
    })
  },
  [type.UPDATE_PRODUCT_REMAIN]: ({state,commit}, productRemain) => {
    HTTP.put('productremains/'+productRemain.id, productRemain).then((response)=>{
      commit(type.UPDATE_PRODUCT_REMAIN, response.data)
    })
  },
  [type.REMOVE_PRODUCT_REMAIN]: ({state,commit}, productRemainId) => {
    HTTP.delete('productremains/'+productRemainId).then((response)=>{
      commit(type.REMOVE_PRODUCT_REMAIN, response.data.id)
    })
  }
}
