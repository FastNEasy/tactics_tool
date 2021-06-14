<template>
  <div id="app">
    <div class="navigation">
      <ul>
        <li>
          <div class="gridItem">
            <router-link to="/createtactic">Create a Tactic</router-link>
          </div>
        </li>
        <li>
          <div class="gridItem">
            <router-link to="/tacticlist">Go to all tactics</router-link>
          </div>
        </li>
        <li>
          <div class="gridItem">
            <router-link to="/testcanvas">Canvas Test</router-link>
          </div>
        </li>
        <li>
          <div class="gridItem">
            <router-link to="/sportlist">Check all Sports</router-link>
          </div>
        </li>
      </ul>
    </div>
    <div class="b">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  //create new state, where after creating a tactic, you get redirected to canvas where the tactic drawing starts
  //start some tactic drawing things
  //maybe do some style a bit
  //check out the three.js for drawing and animation
  //small image in edit tactic to see it
  import SampleRequest from '@/api/sample-request';
  import Cookies from 'js-cookie';
  const sampleRequest = new SampleRequest();
  export default {
    name: 'App',
    created(){
      this.getData();
      this.user = JSON.parse(Cookies.get("UserObject"));
      console.log(this.user);
      console.log(this.$route);
    },
    data(){
      return{
      }
    },
    methods: {
      async getData(){
        const data = await sampleRequest.doRequest();
        console.log('Data:', data);
      },
    },
  };
</script>

<style lang="scss" scoped>
  #app{
    width: auto;
    height: 100vh;
    display: grid;
    grid-template-columns: 15% 1fr;
    //grid-template-rows: 100vh 300px;
    .navigation{
      background: rgba(127, 128, 127, 0.925);//dd
  //     margin: 0;
  //     padding: 0;
  //     width: 200px;
  // //background-color: #f1f1f1;
  //     position: fixed;
  //     height: 100%;
  //     overflow: auto;
      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: rgba(172, 169, 169, 0.925);
        li a {
          display: grid;
          grid-template-rows: 1fr 1fr;
          text-align: center;
          color: #000;
          padding: 12.5px 16px;
          text-decoration: none;
        }
        li a:hover:not(.active) {
          background-color: rgb(25, 136, 30);
          color: white;
        }
        .router-link-exact-active {
          // background-color: rgb(130, 238, 108);
          background-color:#3bc52f;
        }
      }
    }
    .b {// router view atradisies b
      background: rgb(211, 211, 211);//vairaaak stilizet b lauku
     
    }
    .navigation{
      height: 100%;
    }
  }


// body {
//   margin: 0;
//   font-family: "Lato", sans-serif;
// }

// .sidebar {
//   margin: 0;
//   padding: 0;
//   width: 200px;
//   background-color: #f1f1f1;
//   position: fixed;
//   height: 100%;
//   overflow: auto;
// }

// .sidebar a {
//   display: block;
//   color: black;
//   padding: 16px;
//   text-decoration: none;
// }
 
// .sidebar a.active {
//   background-color: #04AA6D;
//   color: white;
// }

// .sidebar a:hover:not(.active) {
//   background-color: #555;
//   color: white;
// }

// div.content {
//   margin-left: 200px;
//   padding: 1px 16px;
//   height: 1000px;
// }

// @media screen and (max-width: 700px) {
//   .sidebar {
//     width: 100%;
//     height: auto;
//     position: relative;
//   }
//   .sidebar a {float: left;}
//   div.content {margin-left: 0;}
// }

// @media screen and (max-width: 400px) {
//   .sidebar a {
//     text-align: center;
//     float: none;
//   }
// }
</style>