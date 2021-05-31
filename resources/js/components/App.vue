<template>
  <div id="app">
    <div class="a">
      <div>
        <input v-model="sportsName" />  
        <button @click="onSave()">save</button>

      </div>
      
      <div>
        <input v-model="tacticsName" />  
        <button @click="needSave()">needSave</button>

        </div>
      <div class="form-group" id="form-add-anim" v-for="(animation,count) in animations" :key="count">
        
        <div v-for="data in model" :key="data.id">
          <input class="inputData" type="number" :v-model="data.name" max="24" width="24" height="24">
        </div>

        
        <button @click="onClickAdd()" v-show="count || ( !count && animations.length > 0)">
          <!-- Click me {{ count }} -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
            class="ml-2 cursor-pointer"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              fill="green"
              d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"
            />
          </svg>
        </button>
        <button @click="onClickRemove(count)" v-show="count == animations.length-1">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
            class="ml-2 cursor-pointer"
          >
            <path fill="none" d="M0 0h24v24H0z" />
            <path
              fill="#EC4899"
              d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
            />
          </svg>
        </button>
        <button type="submit" @click="onClickPrint()" width="24" height="24">Press to save</button>  
      </div>
    </div>
    <div class="b"></div>
    <div class="c"></div>
  </div>
</template>

<script>
import SampleRequest from '@/api/sample-request';
const sampleRequest = new SampleRequest();
export default {
  name: 'App',
  created(){
    this.getData();
  },

  data(){
    return{
      count: 0,
      animations: [{ animation: "" }],
      model: [{}],
      txtFieldVal: 0,
      sportsName: null,
      tacticsName: null,
      idPresets:1,
      idTactics:null,
    }
  },

  methods: {
    async getData(){
      const data = await sampleRequest.doRequest();
      console.log('Data:', data);
    },
    onClickAdd(){
      this.animations.push({ animation: "" });
      this.count++;
    },
    onClickRemove(index){
      if(this.count > 0){
        this.animations.splice(index, 1);
        this.count--;
      }else{
        return;
      }
    },
    onClickPrint(){
      console.log("Data: ", this.txtFieldVal);
    },
    onSave(){
      // orderResource.store(data).then(response => {
      //   }).catch(error => {
      //     console.log(error);
      //   }).finally(() => {
      //     this.saving = false;
      //   });
      sampleRequest.saveSportsType({ sportsTypeName: this.sportsName }).then(response => {
        console.log("Response received", response);
      }).catch(error => {
        console.log("Error",error);
      }).finally(() => {
        
      });
      console.log(`Sports Name: ${this.sportsName}`);
    },
     needSave(){
      sampleRequest.saveTacticName({ tacticsName: this.tacticsName }).then(response => {
        console.log("Response received", response);
      }).catch(error => {
        console.log("Error",error);
      }).finally(() => {
        
      });
      console.log(`Tactics name: ${this.tacticsName}`);
    },
  },
};
</script>
<style lang="scss" scoped>
#app{
    width: 100vw;
   height: 100vh;
	display: grid;
	grid-template-columns: 1fr 1fr 1fr;
  
	.a{
		background: rgb(150,150,150);
    .inputData{
      display:inline;
    }
	}
	.b{
		background: rgb(120,120,120);
	}
	.c{
		background: rgb(130,130,130);
	}
    .a, .b, .c{
        height: 20vh;
    }
}
</style>