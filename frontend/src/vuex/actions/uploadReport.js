import * as type from "../types";
import HTTP from "../../axios";
import Vue from "vue";

export default {
  [type.GET_FILE_LOGS]: ({state,commit}) => {
    HTTP.get('filelogs').then((response)=>{
      Vue.set(state, 'fileLogs', response.data.data);
    })
  },
  [type.ADD_FILE_LOG]: ({state,commit}, file) => {
    let formData = new FormData();
    formData.append('file', file.file);
    formData.append('file_type_id', file.file_type_id);
    formData.append('description', file.description);
    HTTP.post('filelogs', formData).then((response)=>{
      state.fileLogs.push(response.data);
    })
  },
  [type.GET_FILE_TYPES]: ({state,commit}) => {
    HTTP.get('filetypes').then((response)=>{
      Vue.set(state, 'fileTypes', response.data);
    })
  },
}
