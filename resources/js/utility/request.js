/* eslint-disable no-undef */
// import axios from 'axios';

// const service = axios.create({
//   baseURL: process.env.MIX_BASE_API,
//   timeout: 100000,
// });

// service.interceptors.response.use(
//   response => {
//     return response.data;
//   },
//   error => {
//     return Promise.reject(error);
//   },
// );

// export default service;
import axios from 'axios';
import Cookies from 'js-cookie';

const TokenKey = 'XSRF-TOKEN';

function getToken() {
  return Cookies.get(TokenKey);
}
function setToken(token) {
  return Cookies.set(TokenKey, token);
}

// Create axios instance
const service = axios.create({
  baseURL: process.env.MIX_BASE_API,
  timeout: 100000, // Request timeout
});

// Request intercepter
service.interceptors.request.use(
  config => {
    const token = getToken();
    if (token) {
      config.headers['Authorization'] = 'Bearer ' + getToken();
    }

    if (config.params){
      if (config.params.timezone === true){
        config.params = { ...config.params, timezone: Intl.DateTimeFormat().resolvedOptions().timeZone };
      }
    }

    return config;
  },
  error => {
    Promise.reject(error);
  }
);
  
// response pre-processing
service.interceptors.response.use(
  response => {
    if (response.headers.authorization) {
      setToken(response.headers.authorization);
      response.data.token = response.headers.authorization;
    }

    return response.data;
  },
  error => {
    return Promise.reject(error);
  },
);

export default service;