/* eslint-disable no-undef */
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//  require('./bootstrap');

 window.Vue = require('vue');
 
 import Vue from 'vue';
 import VueRouter from 'vue-router';
 import App from './components/App';
 import Edit from './components/Edit';
 import Create from './components/Create';
 import View from './components/View'; 
 import ConfSports from './components/ConfSports';
 import SportInfo from './components/SportInfo';

 //import VueFilename from './componets/VueFilename';
 
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 
 // Vue.component('example-component', require('./components/ExampleComponent.vue').default);`
 Vue.use(VueRouter);
 Vue.config.productionTip = false;
 Vue.config.devtools = true;
 Vue.config.debug = true;
 Vue.config.silent = false;
 
 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
  const routes = [
    { path: '/create', component: Create},
    { path: '/view', component: View },
    { path: '/edit', component: Edit},
    { path: '/confsports', component : ConfSports},
    { path: '/sportinfo/:id', component: SportInfo}
  ]
  const router = new VueRouter({
    routes // short for `routes: routes`
  })
 new Vue({
   el: '#theApp',
   router,
   render: h => h(App),

 });