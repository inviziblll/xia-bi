import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_ROLES]: (state, roles) => {
    Vue.set(state, 'roles', roles)
  },
  [type.ADD_ROLE]: (state, role) => {
    state.roles.push(role);
  },
  [type.UPDATE_ROLE]: (state, role) => {
    state.roles.forEach((element, index) => {
      if(element.id === role.id) {
        Vue.set(state.roles, index, role);
      }
    });
  },
  [type.REMOVE_ROLE]: (state, roleId) => {
    let roles = state.roles.filter((element) => {
      if (element.id !== roleId)
        return element
    });
    Vue.set(state, 'roles', roles);
  }
}
