import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_COMPANIES]: (state, companies) => {
    Vue.set(state, 'companies', companies)
  },
  [type.ADD_COMPANY]: (state, company) => {
    state.companies.push(company);
  },
  [type.UPDATE_COMPANY]: (state, company) => {
    state.companies.forEach((element, index) => {
      if(element.id === company.id) {
        Vue.set(state.companies, index, company);
      }
    });
  },
  [type.REMOVE_COMPANY]: (state, companyId) => {
    let divisions = state.companies.filter((element) => {
      if (element.id !== companyId)
        return element
    });
    Vue.set(state, 'companies', divisions);
  }
}
