import store from '@/vuex';
import * as type from '@/vuex/types';
import router from '@/router'

export default {
  store,
  router,
  install: function (Vue, options) {
    Vue.urlSerialize = (obj) => {
      let str = [];
      for (let p in obj)
        if (obj.hasOwnProperty(p)) {
          if(obj[p] !== null && obj[p].length !== 0)
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
      return str.join("&");
    },
    Vue.checkAuth = () => {
      const token = window.localStorage.getItem('TOKEN');
      if(token !== null){
          store.dispatch(type.CHECK_TOKEN, token).catch(
            result => {router.push({ name: 'Login' })}
          );
      }else{
        if(!store.state.sessions.access_token){
          router.push({ name: 'Login' })
        }else{
          window.localStorage.setItem('TOKEN', store.state.sessions.access_token);
        }
      }
    }
  }
};
