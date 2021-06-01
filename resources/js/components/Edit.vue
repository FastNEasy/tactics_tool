<template>
    <div id="edit">
        <div class="viewEdit">
            <div class="sportsName">
                <!-- parveidot this par dropdown no datu bazes ar presetiem, kas pectam atveras talaak uz taktikas name -->
                <input v-model="sportsName" /> 
                <input
                    type="file" 
                    name="uploadFieldName"  
                    @change="onchange($event.target)"
                    accept="image/*"
                />
                <img id="imageHolder">
                <button class="open-button" @click="onSave()">save</button>
            </div>
        </div>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    //import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'Edit',
        created(){
            this.getData();
            // this.user = JSON.parse(Cookies.get("UserObject"));
            // console.log(this.user);
        },
        data(){
            return{
                // user : null,
                // animations: [{ animation: "" }],
                // model: [{}],
                sportsName: null,
                base64Img: null,
            }
        },
        methods: {
            async getData(){
                const data = await sampleRequest.doRequest();
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
                sampleRequest.saveSportsType({ sportsTypeName: this.sportsName, baseImg: this.base64Img }).then(response => {
                console.log("Response received", response);
                }).catch(error => {
                console.log("Error",error);
                }).finally(() => {});
                console.log(`Sports Name: ${this.sportsName}`);
                console.log(`Sports Pic: ${this.base64Img}`);
            },
        },
    };
</script>

<style lang="scss" scoped>
   
</style>