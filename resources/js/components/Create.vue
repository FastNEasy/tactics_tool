<template>
    <div id="create">
        <div class="addTactic">
            <input v-model="tacticName" placeholder="Taktikas nosaukums" />
            <input type="number" v-model="presetID" placeholder="Speles laukums" />
            <button @click="onTacticAdd()">add tactic</button>
        </div>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
        export default {
            name: 'Create',
            created(){
                this.getData();
                this.user = JSON.parse(Cookies.get("UserObject"));
            },
            data(){
                return{
                    user : null,
                    //potenciali arii preset id, lai zinatu kadam sporta veidam taktika
                    tacticName: null,
                    presetID: 1,
                }
            },
            methods: {
                async getData(){
                    const data = await sampleRequest.doRequest();
                    console.log('Data:', data);
                },
                onTacticAdd(){//adding tactic to the table
                    sampleRequest.saveTactic({ nameTactic: this.tacticName, presetChoice: this.presetID, loginId: this.user }).then(response => {
                        console.log("Response received-2", response);
                    }).catch(error => {
                        console.log("Error-2", error);
                    });
                    console.log(`Tactic name: ${this.tacticName}`);
                },
            },

        };
</script>

<style lang="scss" scoped>

</style>