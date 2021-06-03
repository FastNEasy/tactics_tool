<template>
    <div id="view">
        <h1 class ="tacticsHeading">Tactics Name</h1>
            <table id="tacticsNameTable">
                <tbody>
                    <tr v-for="(tactics,index) in tacticsName" :key="tactics.id">
                        <td class="tacticsNameCell">{{ tactics.tactic_name}}</td>
                        <td class= "tableButtonCell">
                            <div class="buttons">
                                <th><router-link class="button" to="/viewtactic">View</router-link></th>
                                <th><router-link class="button" to="/edittactic">Edit</router-link></th>
                                <th><button class="button" @click="deleteTactic(tactics.id, index)">Delete</button></th>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script>        
    import SampleRequest from '@/api/sample-request';
    import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
        export default {
            name: 'View',
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
                console.log("Removed sport is: ", id);
                // post request kas padod taa elementa id, tad datu baaze ir jasamekle modelis::find(id)->delete
                sampleRequest.deleteTacticName({id}).then(() => {
                    this.tacticsName.splice(index, 1);
                });
            },
                
            }
        }
</script>

<style lang="scss" scoped>
    #view{
        .text-view{
            color: blueviolet;
        }

        #tacticsNameTable{
            font-family: "Lucida Console", "Courier New", monospace;
            border-collapse: collapse;
            width: 100%;
            //border-block: 1px solid black;
        }

        #tacticsNameTable td, #tacticsNameTable th{
            //border: 1px solid rgb(247, 186, 186);
            padding: 10px;
        }
        
        #tacticsNameTable tr:nth-child(even){
            background-color: #e6b288;
        }

         #tacticsNameTable tr:nth-child(odd){
            background-color: #bd987a;
        }

        #tacticsNameTable tr:hover{background-color: #ddd;}

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
            background-color: #f27b72;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            //display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
        }

        button:hover{
            background-color: #f44336;
        }
    }

   
</style>