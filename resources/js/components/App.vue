<template>
  <div id="app">
    <div class="a">
      <div class="sportsName">
        <!-- parveidot this par dropdown no datu bazes ar presetiem, kas pectam atveras talaak uz taktikas name -->
        <!-- state managment  -->
        <input v-model="sportsName" /> 
        <button class="open-button" @click="onSave()">save</button>
      </div>
      <div class = "form-popup" id="myForm">
        <div class="addTactic">
          <input v-model="tacticName" placeholder="Taktikas nosaukums" />
          <input type="number" v-model="presetID" placeholder="Speles laukums" />
          <button @click="onTacticAdd()">add tactic</button>
        </div>
        <!-- padarit pogas pasleptas peec nospieshanas -->
      </div>
      <!-- izveidot jaunu lauku, kuraa iespejams pievienot animaciju(jauna click funkcija, kas izveido animacijas ) -->
      <!-- izveidot iespeju pievienot/nonjemt speletajus un to koordinates fikset tabula ar pogu vai ko tml -->
    </div>
    <div class="b"></div>
    <div class="c"></div>
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
  },

  data(){
    return{
      count: 0,
      user : null,
      animations: [{ animation: "" }],
      model: [{}],
      sportsName: null,
      tacticName: null,
      presetID: 1,//padariit so ka izveli, pectam
    }
  },

  methods: {
    async getData(){
      const data = await sampleRequest.doRequest();
      console.log('Data:', data);
    },
    //saving preset changes
    onSave(){
      // orderResource.store(data).then(response => {
      //   }).catch(error => {
      //     console.log(error);
      //   }).finally(() => {
      //     this.saving = false;
      //   }); piemers pieprasijumam

      document.getElementById("myForm").style.display = "block";
      sampleRequest.saveSportsType({ sportsTypeName: this.sportsName }).then(response => {
        console.log("Response received", response);
      }).catch(error => {
        console.log("Error",error);
      }).finally(() => {
        
      });
      console.log(`Sports Name: ${this.sportsName}`);

      
    },

    //adding tactic to the table
    onTacticAdd(){
      sampleRequest.saveTactic({ nameTactic: this.tacticName, presetChoice: this.presetID, loginId: this.user }).then(response => {
        console.log("Response received-2", response);
      }).catch(error => {
        console.log("Error-2", error);
      });
      console.log(`Tactic name: ${this.tacticName}`);
    },
    onClickAdd(){//revamp this for new button functions
      this.animations.push({ animation: "" });
      this.count++;
    },
    onClickRemove(index){//revamp this for new button functions
      if(this.count > 0){
        this.animations.splice(index, 1);
        this.count--;
      }else{
        return;
      }
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