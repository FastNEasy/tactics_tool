<template>
    <div id="viewtactic">
        <p>Seit ir iespejams apsaktit taktiku</p>
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
        name: 'ViewTactic',
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
                
            }
        },
       
        methods: {
            async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                this.presetID = data.id_presets;
                //this.sportsName= data.sports_type;
                this.image=data.sports_type.field_picture;
                console.log('Data:', data);
                //console.log('sportsNAme: ',this.this.image);
                // this.getFieldData(this.preid);
            },
             
            onSave(){
                sampleRequest.saveTactic({ tacticName: this.tacticName, presetChoice: this.presetID, loginId: this.user}).then(response => {
                console.log("Response received", response);
                }).catch(error => {
                console.log("Error",error);
                }).finally(() => {});
                console.log(`Sports Name: ${this.tacticName}`);
                console.log(`Sports Pic: ${this.presetID}`);
                console.log(`Sports id: ${this.user}`);
            },

            updateAlert(){
                alert("The update was successful!");
            },
            
        },

    };
</script>

<style>

</style>