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
 import CreateSport from './components/CreateSport';
 import CreateTactic from './components/CreateTactic';
 import TacticList from './components/TacticList'; 
 import SportList from './components/SportList';
 import EditSport from './components/EditSport';
 import ViewTactic from './components/ViewTactic';
 import EditTactic from './components/EditTactic';
 import TestCanvas from './components/TestCanvas';

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
    { path: '/createtactic', component: CreateTactic},
    { path: '/tacticlist', component: TacticList },
    { path: '/createsport', component: CreateSport},
    { path: '/sportlist', component : SportList},
    { path: '/editsport/:id', component: EditSport},
    // { path: '/sportinfo', component: SportInfo},
    { path: '/viewtactic/:id', component: ViewTactic},
    { path: '/edittactic/:id', component: EditTactic},
    { path: '/testcanvas', component: TestCanvas},
  ]
  const router = new VueRouter({
    routes // short for `routes: routes`
  })
 new Vue({
   el: '#theApp',
   router,
   render: h => h(App),

 });