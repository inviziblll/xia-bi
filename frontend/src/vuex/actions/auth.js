import * as type from "../types";
import HTTP from "../../axios";
import router from "../../router";

export default {
  [type.SEND_AUTH]: ({commit}, userData) => {
    return new Promise((resolve, reject) => {
      HTTP.post('login', userData).then((response) => {
        commit(type.SEND_AUTH, response.data);
        resolve();
      })
    })
  },
  [type.CHECK_TOKEN]: ({commit}, token) => {
    return new Promise((resolve, reject) => {
      HTTP.get('me', {
        headers: {
          'Authorization': 'Bearer '+token,
        },
      }).then((response) => {
        const userData = {access_token: token, user:response.data};
        commit(type.CHECK_TOKEN, userData);
        resolve();
      }).catch((error) => {
        reject();
      })
    })
  },
  [type.LOGOUT]:({state}) => {
    window.localStorage.removeItem('TOKEN');
    state.sessions = {};
    router.push({name:'Login'})
  }
}
