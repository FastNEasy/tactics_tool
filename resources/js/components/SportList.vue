<template>
    <div id="confsports">
        <h1 class ="tacticsHeading">
           
            Sport Type 
            <router-link class="buttonCreate" to="/createsport">Create new!</router-link>
        </h1>
            <table id="sportsTypeTable">
                <!-- <thead>
                    <tr id="headerT">
                        <th>Sport Type</th>
                        <th><router-link class="buttonCreate" to="/createsport">Create new!</router-link></th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr v-for="(sport, index) in sports" :key="sport.id">
                        <td class="tpyeNameCell">{{ sport.sports_name }}</td>
                        <td class="tableButtonCell">
                            <th><router-link class="button" :to="`/editsport/${sport.id}`" >Edit</router-link></th>
                            <th><button class="button" @click="removePreset(sport.id, index)">Delete</button></th>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'SportList',
        created(){
            this.getData();
         },
    //skats kas displajo visus liidz shim sporta veidus
        data() {
            return {
                sports: {},
                sportName: null,
            };
        },
        methods: {
            async getData(){
                const {data} = await sampleRequest.getSportsTypes();
                this.sports = data;
                this.shout(this.sports);
            },
            editPreset(sport){
                console.log("Need edit sport is: ", sport.sports_name);
            },
            removePreset(id, index){
                console.log("Removed sport is: ", id);
                // post request kas padod taa elementa id, tad datu baaze ir jasamekle modelis::find(id)->delete
                sampleRequest.deleteSportsTypes({id}).then(() => {
                    this.sports.splice(index, 1);
                });
            },
        }    
    };
</script>

<style lang="scss" scoped>
    #confsports{  
            .tacticsHeading{
                text-align: center;
            }
            #sportsTypeTable{
                font-family: Arial;
                border-collapse: collapse;
                width: 60%;
                background: rgb(170, 168, 168);
                border-collapse: collapse;
                border: 1px solid black;
                margin:0 auto;
            }
            #headerT{
                font-size: 30px;
            }
            #sportsTypeTable td, #sportsTypeTable tr{
                border-bottom: 0.5px solid black;
                padding: 10px;
                color:white;
                font-weight: bold;
            }
            // td, tr {
            //     padding: 10px;
            //     border-bottom: 0.5px solid black;
            //     color: white;
            //     text-align: right;
            // }
            tr:hover { 
                background-color: #818181;
                color: rgb(105, 105, 105)
            }
            
            .tpyeNameCell{
                font-size:25px;
                left:30%;
            }

            .tableButtonCell{
                text-align: right;
                width:20%;
            }

            .button{
                display:inline-block;
                padding:0.3em 1.2em;
                margin:0 0.3em 0.3em 0;
                border-radius:2em;
                box-sizing: border-box;
                text-decoration:none;
                font-family:Arial;
                font-weight:bold;
                color:#FFFFFF;
                background-color:#1fc410;
                text-align:center;
                transition: all 0.2s;
            }
            .button:hover {
                background-color: rgb(25, 136, 30);
                color: white;
                cursor: pointer;
            }
            .button-table{
                background-color: white;
                color: black;
                padding: 5px 15px;
                text-decoration: none;
            }
            .button-table:hover {
                background-color: rgb(25, 136, 30);
                color: white;
                cursor: pointer;
            }
            // .buttonCreate{//create new
            //     background-color:#1fc410;
            //     border: none;
            //     color: white;
            //     padding: 10px 24px;
            //     text-align: center;
            //     text-decoration: none;
            //     display: inline-block;
            //     font-size: 20px;
            //     margin: 4px 2px;
            //     cursor: pointer;
            //     border-radius:2em;
            // }
            .buttonCreate:hover {
                background-color: rgb(25, 136, 30);
                color: white;
                cursor: pointer;
            }
        
        // button{
        //     display:inline-block;
        //     font-size:16px;
        //     text-align: center;
        //     margin: 4px 4px;
        // }
    }
</style>