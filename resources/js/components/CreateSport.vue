<template>
    <div id="edit">
        <div class="viewEdit">
            <div class="sportsName">
                <p v-if="errors.length">
                    <b>Please fill all fields:</b>
                    <ul>
                        <li v-for="error in errors" v-bind:key="error.id">{{ error }}</li>
                    </ul>
                </p>
                <form @submit="checkForm">
                    <input class="sportsNameInput" v-model="sportsName" placeholder="Sport name e.g Basketball" /><br><br>
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
                    <button type="submit" id="saveButton" v-on:click.once="onSave();">Save</button>
                </form>
                <img id="imageHolder">
                <!-- <button v-on:click.once="onSave()" class="saveButton">Save</button> -->
            </div>
            <router-link class="button-link" to="/sportlist">Return to list!</router-link>
        </div>
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    //import Cookies from 'js-cookie';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'CreateSport',
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
                errors: [],
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
                // console.log(`Sports Pic: ${this.base64Img}`);
            },

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

            // refreshPage(){
            //     window.location.reload();
            // }, 
        },
    };
</script>

<style lang="scss" scoped>
    #edit{
        text-align: center;
        padding-top:50px;
        .button-link {//return to list
            background-color:#1fc410;
            border:1px solid #1b9429;
            //border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            //margin: 4px 2px;
            cursor: pointer;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 5px;
            
            
        }
        .button-link:hover {
            background-color: rgb(25, 136, 30);
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
        }
        .file-input label { //select image
            display: block;
            position: relative;
            width: 200px;
            height: 50px;
            margin:auto;
            border-radius: 25px;
            background-color:#1fc410;
            border:1px solid #1b9429;
           // box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: transform .2s ease-out;
            margin-bottom: 5px;
            
        }

        .file-input label:hover{
            background-color: rgb(25, 136, 30);
        }

        .file-input label:active{
            top: 1px;
        }

        #saveButton {//save butenn
            background-color:#1fc410;
            border-radius:25px;
            border:1px solid #1b9429;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-size:20px;
            padding:10px 24px;
            text-decoration:none;
            font-weight: bold;
            margin-bottom: 15px;
            //text-shadow:0px 1px 0px #2f6627;
        }

        #saveButton:hover {
            background-color: rgb(25, 136, 30);
        }

        #saveButton:active {
            position:relative;
            top:1px;
        }

        #saveButton:disabled{
            background-color:#90b97c;
        }
    }
</style>