<template>
    <div id="tacticlist">
        <h1 class ="tacticsHeading">
            Created Tactics
            <router-link class="buttonCreate" to="/createtactic">Create a Tactic </router-link>
        </h1>
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
    const sampleRequest = new SampleRequest();
        export default {
            name: 'TacticsList',
            created(){
                this.user = this.getUserCookie();
                this.getData();
                console.log("User: ", this.user);
            },
            data(){
                return{
                    tacticsName: {},
                }
            },
            methods:{
                async getData(){
                    const {data} = await sampleRequest.getTacticName({id_user: this.user.id});
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
        // .text-view{
        //     // color: rgb(160, 159, 161);
        // }
        #tacticsNameTable{
            // font-family: "Lucida Console", "Courier New", monospace;
            // border-collapse: collapse;
            // width: 60%;
            // background: gray;
            // border-collapse: collapse;
            // border: 1px solid black;
            // margin:0 auto;
            //border-block: 1px solid black;
            font-family: Arial;
            border-collapse: collapse;
            width: 60%;
            background: rgb(170, 168, 168);
            border-collapse: collapse;
            border: 1px solid black;
            margin:0 auto;
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
        #tacticsNameTable tr:hover{
            background-color: #818181;
            color: rgb(105, 105, 105)
            // border-radius:12cm;
            }
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
            font-family:Arial;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1fc410;
            text-align:center;
            transition: all 0.2s;
        }
        .button:hover{
            background-color: rgb(25, 136, 30);
            color: white;
            cursor: pointer;
        }
        // .buttonCreate{
        //     background-color: #1db40f;
        //     border: none;
        //     color: white;
        //     padding: 10px 24px;
        //     text-align: center;
        //     text-decoration: none;
        //     display: inline-block;
        //     font-size: 20px;
        //     margin: 4px 2px;
        //     cursor: pointer;
        // }
       .buttonCreate:hover {
            background-color: rgb(25, 136, 30);
            color: white;
            cursor: pointer;
        }
    }

   
</style>