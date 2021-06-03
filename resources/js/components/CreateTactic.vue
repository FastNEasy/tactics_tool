<template>
    <div id="create">
        <div class="addTactic">

            <label class="label_font" for="presetsid">Choose a sport!</label><br><br>
            <select name="presets" id="presetsid" >
                <option hidden value="" >No sport assigned </option>
                <option v-for="(sport) in sports" :key="sport.id" v-bind:value="sport.id">{{ sport.sports_name }}</option>
            </select><br><br>
            <!-- <input type="number" v-model="presetID" placeholder="Sporta veids" /> -->
            <input id="tacticName" v-model="tacticName" placeholder="Taktikas nosaukums" required><br><br>
            
            <button class="saveButton" @click="onTacticAdd(); insertAlert()">Add tactic</button>
            <p id="saveButton"></p>
        
        </div>
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
                myFunction() {
                    document.getElementById("myDropdown").classList.toggle("show");
                },

                insertAlert(){
                    alert("Inserted Successfully!");
                }
            },

        };
</script>

<style lang="scss" scoped>
    #create{
        text-align: center;
        padding-top:20px;
        
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
        }

        

        .saveButton {
            background-color:#44c767;
            border-radius:28px;
            border:1px solid #18ab29;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-size:17px;
            padding:16px 31px;
            text-decoration:none;
            text-shadow:0px 1px 0px #2f6627;
        }

        .saveButton:hover {
            background-color:#5cbf2a;
        }

        .saveButton:active {
            position:relative;
            top:1px;
        }
    }
</style>