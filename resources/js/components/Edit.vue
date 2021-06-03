<template>
    <div id="edit">
        <div class="viewEdit">
            <div class="sportsName">
                <!-- parveidot this par dropdown no datu bazes ar presetiem, kas pectam atveras talaak uz taktikas name -->
                <input class="sportsNameInput" v-model="sportsName" placeholder="Name of the sport" /><br><br>
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
             
                

                <img id="imageHolder">
                <router-link @click.native="onSave()" class="saveButton" to="/confsports">Save</router-link>
            </div>
            <router-link class="button-link" to="/confsports">Return to list!</router-link>
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
                // console.log(`Sports Pic: ${this.base64Img}`);
            },

            refreshPage(){
                window.location.reload();
            }, 
        },
    };
</script>

<style lang="scss" scoped>
    #edit{
        text-align: center;
        padding-top:5%;
        .button-link {
            background-color: #5e645d;
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .button-link:hover {
            background-color: rgb(160, 33, 33);
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
        .file-input label {
            display: block;
            position: relative;
            width: 200px;
            height: 50px;
            margin:0 auto;
            border-radius: 25px;
            background: linear-gradient(40deg, #636060, #73f579);
            box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: transform .2s ease-out;
        }

        .file-input label:hover{
            background: linear-gradient(40deg, #929090, #97f39c);
        }

        .file-input label:active{
            top: 1px;
        }

        .saveButton {
            background-color:#44c767;
            border-radius:28px;
            border:1px solid #18ab29;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-size:17px;
            padding:16px 31px;
            text-decoration:none;
            text-shadow:0px 1px 0px #2f6627;
        }

        .saveButton:hover {
            background-color:#5cbf2a;
        }

        .saveButton:active {
            position:relative;
            top:1px;
        }
    }
</style>