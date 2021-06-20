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
        <!-- <li>
          <div class="gridItem">
            <router-link to="/testcanvas">Canvas Test</router-link>
          </div>
        </li> -->
        <li>
          <div class="gridItem">
            <router-link to="/sportlist">Check all Sports</router-link>
          </div>
        </li>
       <li>
          <div class="gridItem">
           <!-- <li> -->
            <a v-on:click="onLogout()" >Logout</a>
            <!-- </li>  -->
            <!-- <a id="logout-link" href="#" @click.prevent="logout">Logout</a> -->
          <!-- <button type="submit" class="btn btn-{{onLogout()}}"> </button> -->
          <!-- <button type="submit" :class="`btn btn-${onLogout}`"> </button> -->
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
    // props: [
    //     'onLogout'
    // ],
    data(){
      return{
      }
    },
    methods: {
      async getData(){
        const data = await sampleRequest.doRequest();
        console.log('Data:', data);
      },
      onLogout(){
        console.log('test');
        this.$emit('logout()');
        document.getElementById("logout-form").submit();
        
      },
     
    },
  };
</script>

<style lang="scss" scoped>
  #app{
    width: auto;
    height: 100vh;
    display: grid;
    grid-template-columns: 10% 1fr;
    //grid-template-rows: 100vh 300px;
    .navigation{
      background: rgba(172, 169, 169, 0.925);//dd
  
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
          cursor: pointer;
        }
        li a:hover:not(.active) {
          background-color: rgb(25, 136, 30);
          color: white;
        }
        .router-link-exact-active {
          // background-color: rgb(130, 238, 108);
          cursor: pointer;
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



</style>