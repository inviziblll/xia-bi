import Vue from "vue";
import * as type from "../types";

export default {
  [type.GET_CLIENTS]: (state, clients) => {
    Vue.set(state, 'clients', clients)
  },
  [type.ADD_CLIENT]: (state, client) => {
    state.clients.push(client);
  },
  [type.UPDATE_CLIENT]: (state, client) => {
    state.clients.forEach((element, index) => {
      if(element.id === client.id) {
        Vue.set(state.clients, index, client);
      }
    });
  },
  [type.REMOVE_CLIENT]: (state, clientId) => {
    let clients = state.clients.filter((element) => {
      if (element.id !== clientId)
        return element
    });
    Vue.set(state, 'clients', clients);
  }
}
