<template>
    <div id="viewtactic">
        <p>Seit ir iespejams redigeEt taktiku</p>
        <div class ="buttons">
            <input class="tacticsName" v-model="tacticName" placeholder="Name of the sport"  /><br><br>
            <img :src="image">
            <img id="imageHolder">
            <button class="updateButton" type="submit" @click=" onSave(); updateAlert()">Update</button><br><br>

        </div>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'EditTactic',
        created(){
            this.getData();
           
        },
        data(){
            return{
                tactics: {},
                id: this.$route.params.id,
                tacticName: null,
                image: null,
                sports: {},
                sportsName: null,
                base64Img: null,
                presetID: null,
                user : null,
                
            }
        },
       
        methods: {
            async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                this.presetID = data.id_presets;
                this.userID = data.id_user;
                //this.sportsName= data.sports_type;
                this.image=data.sports_type.field_picture;
                console.log('USERid:', this.id_user);
                console.log('Dattta:', data);
                console.log('USERid:', data.id_user);
                //console.log('sportsNAme: ',this.this.image);
                // this.getFieldData(this.preid);
            },
             
            onSave(){//adding tactic to the table
                  //this.presetID = document.getElementById("presetsid").value;
                    sampleRequest.updateTactics({ id:this.id, tacticName: this.tacticName }).then(response => {
                        console.log("Response received-2", response);
                    }).catch(error => {
                        console.log("Error-2", error);
                    });
                    //document.getElementById("saveButton").innerHTML = "Tactic added";
                    console.log(`Tactic name: ${this.tacticName}`);
                     console.log(`preset   ${this.presetID}`);
                     console.log(`user id: ${this.userID}`);
                },

            updateAlert(){
                alert("The update was successful!");
            },
            
        },

    };
</script>

<style lang="scss" scoped>

</style>