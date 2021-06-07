<template>
    <div id="tacticlist">
        <h1 class ="tacticsHeading">Created Tactics</h1>
            <table id="tacticsNameTable">
                <tbody>
                    
                    <tr v-for="(tactics,index) in tacticsName" :key="tactics.id">
                        <td class="tacticsNameCell">{{ tactics.tactic_name }}</td>
                        <td class= "tableButtonCell">
                            <div class="buttons">
                                <th><router-link class="button" :to="`/viewtactic/${tactics.id}`">View</router-link></th>
                                <th><router-link class="button" :to="`/edittactic/${tactics.id}`">Edit</router-link></th>
                                <th><button class="button" @click="deleteTactic(tactics.id, index)">Delete</button></th>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script> 
//create so that displays tactics preset name        
    import SampleRequest from '@/api/sample-request';
    import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
        export default {
            name: 'TacticsList',
            created(){
                this.getData();
                this.user = JSON.parse(Cookies.get("UserObject"));
            },
            data(){
                return{
                    tacticsName: {},
                }
            },
            methods:{
                async getData(){
                    const {data} = await sampleRequest.getTacticName();
                    this.tacticsName = data;
                    console.log('Data:', data);
                },
                deleteTactic(id, index){
                    console.log("Removed tactic is: ", id);
                    // post request kas padod taa elementa id, tad datu baaze ir jasamekle modelis::find(id)->delete
                    sampleRequest.deleteTacticName({id}).then(() => {
                        this.tacticsName.splice(index, 1);
                    });
                },
            }
    }

</script>

<style lang="scss" scoped>
    #tacticlist{
        .text-view{
            color: blueviolet;
        }

        #tacticsNameTable{
            font-family: "Lucida Console", "Courier New", monospace;
            border-collapse: collapse;
            width: 60%;
            background: gray;
            border-collapse: collapse;
            border: 1px solid black;
            margin:0 auto;
            //border-block: 1px solid black;
        }

        #tacticsNameTable td{
            border-bottom: 0.5px solid black;
            padding: 10px;
            color:white;
            font-weight: bold;
        }
        
        // #tacticsNameTable tr:nth-child(even){
        //     background-color: #e6b288;
        // }

        //  #tacticsNameTable tr:nth-child(odd){
        //     background-color: #bd987a;
        // }

        #tacticsNameTable tr:hover{background-color: #7a7171;}

        .tacticsHeading{
            text-align: center;
        }

        .tacticsNameCell{
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
            font-family:'Roboto',sans-serif;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1db40f;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }
    }

   
</style>