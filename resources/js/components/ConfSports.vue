<template>
    <div id="confsports">
        <div class="displayTables">
            <table class="table">
                <thead>
                    <tr id="headerT">
                        <th>Sport Type</th>
                        <th><router-link class="button-link" to="/edit">Create new!</router-link></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sport, index) in sports" :key="sport.id">
                        <td>{{ sport.sports_name }}</td>
                        <td>
                            <button @click="editPreset(sport)">Edit</button>
                            <button @click="removePreset(sport.id, index)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'ConfSports',
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
                console.log('Data:', this.sports);
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
        .displayTables{
            table{
                margin-left: 25%; 
                background: gray;
                border-collapse: collapse;
                border: 1px solid black;
            }
            #headerT{
                font-size: 20px;
            }
            th, td, tr {
                padding: 10px;
                border-bottom: 0.5px solid black;
                color: white;
            }
            tr:hover {
                background-color: #ca4a4a;
                color: rgb(80, 67, 67)
            }
            .button-link {
                background-color: #1db40f;
                border: none;
                color: white;
                padding: 10px 24px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 20px;
                margin: 4px 2px;
                cursor: pointer;
            }
            .button-link:hover {
                background-color: rgb(160, 33, 33);
            }
        }
    }
</style>