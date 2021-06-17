<template>
    <div id="create">
        <div class="addTactic">
            <p v-if="errors.length">
                <b>Please fill all fields:</b>
                <ul>
                    <li v-for="error in errors" v-bind:key="error.id">{{ error }}</li>
                </ul>
            </p>
            <form @submit="checkForm" action="/action_page.php">
                <!-- action= "http://localhost:3000/#/tacticlist" method="POST" -->
                <label class="label_font" for="presetsid">Choose a sport!</label><br><br>
                <select name="presets" id="presetsid" >                    <option hidden value="" >No sport assigned </option>
                    <option v-for="(sport) in sports" :key="sport.id" v-bind:value="sport.id">{{ sport.sports_name }}</option>
                </select><br><br>
                <!-- <input type="number" v-model="presetID" placeholder="Sporta veids" /> -->
                <input id="tacticName" v-model="tacticName" placeholder="Tactic name e.g Defense"><br><br>        
                <button type="submit" id="saveButton" class="saveButton" v-on:click.once=" onTacticAdd(); toAllTactics()" >Add tactic name</button><br> <br>
                <!-- <router-link class="saveButton" v-on:click.once="onTacticAdd();" to="/tacticlist" >To all tactics!</router-link> -->
                <p id="saveButton"></p>
                
            </form>   
        </div>
        <!-- </form> -->
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
        export default {
            name: 'CreateTactic',
            created(){
                this.getData();
                this.user = JSON.parse(Cookies.get("UserObject"));
            },
            data(){
                return{
                    errors: [],
                    user : null,
                    //potenciali arii preset id, lai zinatu kadam sporta veidam taktika
                    sports: {},
                    tacticName: null,
                    presetID: null,
                }
            },
            methods: {
                async getData(){
                    const {data} = await sampleRequest.getSportsTypes();
                    this.sports = data;
                },
                onTacticAdd(){//adding tactic to the table
                    this.presetID = document.getElementById("presetsid").value;
                    sampleRequest.saveTactic({ nameTactic: this.tacticName, presetChoice: this.presetID, loginId: this.user }).then(response => {
                        console.log("Response received-2", response);
                    }).catch(error => {
                        console.log("Error-2", error);
                    });
                    //document.getElementById("saveButton").innerHTML = "Tactic added";
                    console.log(`Tactic name: ${this.tacticName}`);
                },

                insertAlert(){
                    alert("Inserted Successfully! Tactic is available in all tactic list.");
                },
                toAllTactics(){
                    console.log('sss');
                    location.href = "#/tacticlist/";
                    
                },

                checkForm(e){
                if(this.tacticName&& this.presetID){
                    console.log("CHECK FORM FUNCTION CALLED");
                }
                this.errors = [];
                if(!this.tacticName){
                    this.errors.push("Name required.")
                }
                if(!this.presetID){
                    this.errors.push("Choose a sport")
                }
                
                console.warn("errors",this.error)
                e.preventDefault();
            },       
            },

        };
</script>

<style lang="scss" scoped>
    #create{
        text-align: center;
        padding-top:50px;
        
        .label_font{
            font-size: 24px;
            
        }
       
        #tacticName{
            width:200px; 
            height: 40px;
            font-size: 18px; 
            border-radius:8px;
        }
        
        #presetsid{
            width:180px; 
            height: 40px;
            font-size: 18px;  
            border-radius:8px;
            //background-color:#d6d6d6;
        }

        

        .saveButton { //add tactic
            background-color:#1fc410;
            border-radius:28px;
            border:1px solid #1b972a;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-weight: bold;
            font-size:17px;
            padding:16px 31px;
            text-decoration:none;
            //text-shadow:0px 1px 0px #2f6627;
        }

        .saveButton:hover {
                background-color: rgb(27, 155, 34);
        }

        .saveButton:active {
            position:relative;
            top:1px;
        }
    }
</style>