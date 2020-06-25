import * as type from "../types";
import HTTP from "../../axios";
import router from "../../router";

export default {
  [type.GET_REPORTS]: ({state, commit}) => {
    return new Promise((resolve, reject) => {
      HTTP.get('reports', {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {
        commit(type.GET_REPORTS, response.data);
        console.log('res ',response.data)
        resolve();
      })
    })
  },
  [type.GET_REPORTS_SHARE]: ({state, commit}) => {
    return new Promise((resolve, reject) => {
      HTTP.get('reportshares', {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {
        commit(type.GET_REPORTS_SHARE, response.data);
        resolve();
      })
    })
  },
  [type.GET_DIVISION_MONTH_REPORT]: ({state, commit}) => {
    return new Promise((resolve, reject) => {
      HTTP.get('reportmonth', {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {

        commit(type.GET_DIVISION_MONTH_REPORT, response.data);
        resolve();
      })
    })
  },
  [type.GET_DIVISION_PIE_MONTH_REPORT]: ({state, commit}) => {
    return new Promise((resolve, reject) => {
      HTTP.get('reportmonthpie', {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {

        commit(type.GET_DIVISION_PIE_MONTH_REPORT, response.data);
        resolve();
      })
    })
  },
  [type.SHARE_REPORT]: ({state, commit}, reportShare) => {
    return new Promise((resolve, reject) => {
      HTTP.post('reportshares', reportShare, {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then(() => {
        resolve();
      })
    })
  },
  [type.REMOVE_SHARE_REPORT]: ({state,commit}, reportShareId) => {
    HTTP.delete('reportshares/'+reportShareId, {
      headers: {
        'Authorization': 'Bearer '+state.sessions.access_token,
      },
    }).then(() => commit(type.REMOVE_SHARE_REPORT, reportShareId))
  },
  [type.ADD_REPORT]: ({state, commit}, report) => {
    return new Promise((resolve, reject) => {
      HTTP.post('reports', report, {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {
        commit(type.ADD_REPORT, response.data);
        resolve();
      })
    })
  },
  [type.UPDATE_REPORT]: ({state, commit}, report) => {
    return new Promise((resolve, reject) => {
      HTTP.put('reports/'+report.id, report, {
        headers: {
          'Authorization': 'Bearer '+state.sessions.access_token,
        },
      }).then((response) => {
        // commit(type.UPDATE_REPORT, response.data);
        resolve();
      })
    })
  },
  [type.REMOVE_REPORT]: ({state,commit}, reportId) => {
    HTTP.delete('reports/'+reportId, {
      headers: {
        'Authorization': 'Bearer '+state.sessions.access_token,
      },
    }).then((response)=>{
      commit(type.REMOVE_REPORT, response.data.id)
    })
  }
}
