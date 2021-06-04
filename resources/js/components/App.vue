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
    width: 100vw;
    height: 100vh;
    display: grid;
    grid-template-columns: 200px 1fr;
    grid-template-rows: 200px 300px;
    .navigation{
      background: rgba(173, 159, 159, 0.925);
      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: rgba(173, 27, 27, 0.925);
        li a {
          display: grid;
          grid-template-rows: 1fr 1fr;
          text-align: center;
          color: #000;
          padding: 12.5px 16px;
          text-decoration: none;
        }
        li a:hover:not(.active) {
          background-color: rgba(212, 73, 73, 0.945);
          color: white;
        }
        .router-link-exact-active {
          background-color: rgb(0, 216, 65);
        }
      }
    }
    .b {// router view atradisies b
      background: rgb(150,150,100);//vairaaak stilizet b lauku
    }
    .navigation, .b{
      height: 100vh;
    }
  }

</style>