<template>
    <div id="viewtactic">
        <h3>{{ tacticName }}</h3>
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
            }
        },
        methods: {
            async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                console.log('Data:', data);
            }
        },

    };
</script>

<style lang="scss" scoped>

</style>