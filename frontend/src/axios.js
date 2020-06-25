import axios from 'axios';
import store from './vuex';
import router from './router';

const HTTP = axios.create({
    baseURL: process.env.BASE_URL
});

HTTP.interceptors.response.use((response) => {
  return response;
},
  // function (error) {
  //   console.log(error);
  //   let status = error.response.status;
  //   if (status === 401) {
  //     //Erorr sessions
  //     console.log('ERROR AXIOS', 401);
  //   } else if (status === 403) {
  //     //Error Access Denied
  //     console.log('ERROR AXIOS', 403);
  //   } else if (status === 404) {
  //     //Error Not Found Page
  //     console.log('ERROR AXIOS', 404);
  //   } else if (status === 500 || status === 400) {
  //     //Error all
  //     console.log('ERROR AXIOS 500', error);
  //   }
  // }
);

export default HTTP;


