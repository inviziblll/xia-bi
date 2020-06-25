import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_REPORTS]:(state, reports) => {
    Vue.set(state, 'reports', reports)
  },
  [type.GET_REPORTS_SHARE]:(state, reportsShare) => {
    Vue.set(state, 'reportsShare', reportsShare)
  },
  [type.ADD_REPORT]:(state, report) => {
    state.reports.push(report);
  },
  [type.REMOVE_SHARE_REPORT]:(state, reportsShareId) => {
    let reportsShare = state.reportsShare.filter((element) => {
      if (element.id !== reportsShareId)
        return element
    });
    Vue.set(state, 'reportsShare', reportsShare);
  },
  [type.REMOVE_REPORT]:(state, reportId) => {
    let reports = state.reports.filter((element) => {
      if (element.id !== reportId)
        return element
    });
    Vue.set(state, 'reports', reports);
  },
  [type.GET_DIVISION_MONTH_REPORT]:(state, data) => {

    Vue.set(state, 'divisionMonthReports', data);
  },
  [type.GET_DIVISION_PIE_MONTH_REPORT]:(state, data) => {

    Vue.set(state, 'divisionPieMonthReports', data);
  }
}
