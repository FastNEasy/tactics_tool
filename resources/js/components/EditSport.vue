<template>
    <div id="sportinfo">
        <div class="viewEdit">
            <div class="sportsName">
                <p v-if="errors.length">
                    <b>Please fill all fields:</b>
                    <ul>
                        <li v-for="error in errors" v-bind:key="error.id">{{ error }}</li>
                    </ul>
                </p>
                <form @submit="checkForm">
                    <input class="sportsNameInput" v-model="sportsName" placeholder="Name of the sport"/><br><br>
                    <div class="file-input">
                        <input
                            type="file" 
                            id="file"
                            class="file"  
                            @change="onchange($event.target)"
                            accept="image/*"
                        >
                        <label for="file">Select Image</label><br><br>
                    </div>
                    <!-- <img id="imageHolder"> -->
                    <button class="updateButton" type="submit" @click="onSave(); /*updateAlert();*/">Update</button><br><br>
                </form>
            </div>
            <router-link class="button-link" to="/sportlist">Return to list!</router-link>
        </div>
        <img class="updateImage" v-bind:src="image">
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
         name: 'EditSport',
        created(){
            this.getData();
            
        },
         data(){
            return{
                sports: {},
                sportsName: null,
                base64Img: null,
                id: this.$route.params.id, //pagaidam statisks 
                image: null,
                errors:[],
            }
        },
        methods:{
            
        async getData(){
                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getSportsTypes({ id:this.id});
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data);  
            },
            async onchange(data){
                console.log(data.files);
                // var elem = document.getElementById("imageHolder");
                const toBase64 = file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
                const base64Img= await toBase64(data.files[0]);
                // elem.src=base64Img;
                this.base64Img = base64Img;
                this.image = base64Img;
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

            // updateAlert(){
            //     alert("The update was successful!");
            // },

           checkForm(e){
                if(this.sportsName&& this.base64Img){
                    console.log("CHECK FORM FUNCTION CALLED");
                }
                this.errors = [];
                if(!this.sportsName){
                    this.errors.push("Name required.")
                }
                if(!this.base64Img){
                    this.errors.push("picture required")
                }
                console.warn("errors",this.error)
                e.preventDefault();
            },
    
            
        },
    };
</script>

<style lang="scss" scoped>
    #sportinfo{
        text-align: center;
        padding-top:1%;
        .text-view{
            color: rgb(85, 85, 85);
        }

        .sportsNameInput{
            width:30%;
            height: 5vh;
            font-size:20px;
       }

        .file {
            opacity: 0;
            width: 0.1px;
            height: 0.1px;
            position: absolute;
            margin-top:50%;
        }
        .file-input label {
            display: inline-block;
            //position: relative;
            // width: 200px;
            // height: 50px;
            // margin:0 auto;
            border-radius: 20px;
            background-color:#1fc410;            //box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
            border:1px solid #057505;
            cursor:pointer;
            color: white;
            font-family:Arial;
            font-size: 22px;
            padding: 10px 24px;
            text-align: center;
            text-decoration:none;
            margin: 4px 2px;
        }
        .updateButton {
            background-color:#1fc410;           
            border-radius:20px;
            border:1px solid #057505;
            display: inline-block;
            cursor:pointer;
            color: white;
            font-family:Arial;
            font-size: 22px;
            padding: 10px 24px;
            text-align: center;
            text-decoration:none;
            margin: 4px 2px;
        }

        .file-input label:hover{
                background-color: rgb(25, 136, 30);
        }

        // .file-input label:active{
        //     top: 1px;
        // }

        
        .button-link {
            background-color:#1fc410;            
            border:1px solid #057505;
            border-radius:20px;
            
            display: inline-block;
            cursor:pointer;
            color: white;
            font-family:Arial;
            font-size: 22px;
            padding: 10px 24px;
            text-align: center;
            text-decoration:none;
            margin: 4px 2px;
            
        }

        .updateButton:hover {
           // background-color:#585858;
                background-color: rgb(25, 136, 30);
        }

        // .updateButton:active {
        //     position:relative;
        //     top:1px;
        // }

        .updateImage{
            margin-top:2%;
            width:70%;
        }

        
        .button-link:hover {
                background-color: rgb(25, 136, 30);
        }
    }
    
</style>
