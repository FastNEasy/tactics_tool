<template>
    <div id="sportinfo">
        <div class="viewEdit">
            <div class="sportsName">
                <input v-model="sportsName" /> 
                <input
                    type="file" 
                    name="uploadFieldName"  
                    @change="onchange($event.target)"
                    accept="image/*"
                />
                <img id="imageHolder">
                <button class="open-button" @click="onSave()"> update </button>
            </div>
        </div>
        
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        created(){
            this.getData();
            // this.user = JSON.parse(Cookies.get("UserObject"));
            // console.log(this.user);
            // console.log(this.$route.params.id);
        },
         data(){
            return{
                sports: {},
                sportsName: null,
                base64Img: null,
                id: this.$route.params.id, //pagaidam statisks 
            }
        },
        methods:{
            
        async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getSportsTypes({ id:this.id});
                this.sportsName = data.sports_name;
                this.sport = data;
                console.log('Data:', data);  
            },
            async onchange(data){
                console.log(data.files);
                var elem = document.getElementById("imageHolder");
                const toBase64 = file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
                const base64Img= await toBase64(data.files[0]);
                elem.src=base64Img;
                this.base64Img = base64Img;
            },
            onSave(){
                sampleRequest.updateSportsType({id: this.id, sportsTypeName: this.sportsName, baseImg: this.base64Img }).then(response => {
                console.log("Response received", response);
                }).catch(error => {
                console.log("Error",error);
                }).finally(() => {});
                console.log(`Sports Name: ${this.sportsName}`);
                console.log(`Sports Pic: ${this.base64Img}`);
                console.log(`Sports id: ${this.id}`);
            },
            
        },
    };
</script>

<style lang="scss" scoped>
    #sportinfo{
        .text-view{
            color: rgb(104, 250, 59);
        }
    }
    
</style>
