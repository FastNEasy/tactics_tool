<template>
    <div id="viewtactic">
        <h3>{{ tacticName }}</h3>
        <img :src="image">
        <!-- <img id="imageHolder"> -->
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
                presetID: null,
                ser : null,
                image: null,
            }
        },
        methods: {
            async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                console.log('Data:', data);
                this.presetID = data.id_presets;
                this.userID = data.id_user;
                //this.sportsName= data.sports_type;
                this.image=data.sports_type.field_picture;
                console.log('USERid:', this.id_user);
                console.log('Dattta:', data);
                console.log('USERid:', data.id_user);
            }
        },
    };
</script>

<style lang="scss" scoped>

</style>