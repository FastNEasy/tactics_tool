<template>
    <div id="create">
        <div class="addTactic">
            <input v-model="tacticName" placeholder="Taktikas nosaukums" />
            <label class="label_font" for="presetsid">Choose a sport!</label>
            <select name="presets" id="presetsid">
                <option>No sport assigned</option>
                <option v-for="(sport) in sports" :key="sport.id" v-bind:value="sport.id">{{ sport.sports_name }}</option>
            </select>
            <!-- <input type="number" v-model="presetID" placeholder="Sporta veids" /> -->
            <button @click="onTacticAdd()">add tactic</button>
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
                    console.log(`Tactic name: ${this.tacticName}`);
                },
                myFunction() {
                    document.getElementById("myDropdown").classList.toggle("show");
                }
            },

        };
</script>

<style lang="scss" scoped>
    #create{
        .label_font{
            font-size: 12px;
        }
    }
</style>