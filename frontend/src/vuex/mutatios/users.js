import Vue from "vue";
import * as type from "../types";
import HTTP from "../../axios";
import state from "../state";

export default {
  [type.GET_USERS]: (state, users) => {
    Vue.set(state, 'users', users)
  },
  [type.ADD_USER]: (state, user) => {
    state.users.push(user);
  },
  [type.UPDATE_USER]: (state, user) => {
    state.users.forEach((element, index) => {
      if(element.id === user.id) {
        Vue.set(state.users, index, user);
      }
    });
  },
  [type.REMOVE_USER]: (state, userId) => {
    let users = state.users.filter((element) => {
      if (element.id !== userId)
        return element
    });
    Vue.set(state, 'users', users);
  }
}
