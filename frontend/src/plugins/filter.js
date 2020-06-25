import store from '@/vuex';
import moment from 'moment'

export default {
  store,
  install: function (Vue, options) {
    Vue.filter('date',(date)=>{
      if(date != null)
        return (new Date(date)).toLocaleDateString();
      else
        return '';
    });
    Vue.filter('dateTime',(date)=>{
      if(date != null)
        return (new Date(date)).toLocaleDateString() +' '+ (new Date(date)).toLocaleTimeString();
      else
        return '';
    });
  }
};
