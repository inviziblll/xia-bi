import * as type from "../types";
import HTTP from "../../axios";
import Vue from "vue";

export default {
  [type.GET_VISIT_LOGS]: ({state,commit}, {page, search}) => {
    let urlSearch = '';
    if(typeof search === 'object'){
      urlSearch = Vue.urlSerialize(search);
      if(urlSearch !== ''){
        urlSearch = '&'+urlSearch;
      }
    }
    HTTP.get('visitlogs?page='+page+urlSearch).then((response)=>{
      commit(type.GET_VISIT_LOGS, response.data.data);
      delete response.data.data;
      commit(type.GET_PAGE_CONTROLLER, response.data)
    }).catch((error) => {
      commit(type.NOTIFICATION, {type: 'error', text: "По данным фильтрам, остатков не найдено!!!"})
    })
  },
  [type.GET_VISIT_LOG]: ({commit, state}, visitLogId) => {
    return new Promise((resolve, reject) => {
      HTTP.get('visitlogs/'+visitLogId).then((response)=>{
        resolve(response.data);
      })
    })
  },
  [type.ADD_VISIT_LOG]: ({state,commit}, visitLog) => {
    HTTP.post('visitlogs', visitLog).then((response)=>{
      commit(type.ADD_VISIT_LOG, response.data)
    })
  },
  [type.UPDATE_VISIT_LOG]: ({state,commit}, visitLog) => {
    HTTP.put('visitlogs/'+visitLog.id, visitLog).then((response)=>{
      commit(type.UPDATE_VISIT_LOG, response.data)
    })
  },
  [type.REMOVE_VISIT_LOG]: ({state,commit}, visitLogId) => {
    HTTP.delete('visitlogs/'+visitLogId).then((response)=>{
      commit(type.REMOVE_VISIT_LOG, response.data.id)
    })
  }
}
