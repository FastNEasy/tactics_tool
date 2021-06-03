<template>
    <div id="sportinfo">
        <div class="viewEdit">
            <div class="sportsName">
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
                  <button class="updateButton" type="submit" @click="onSave()">Update</button><br><br>
            </div>
        </div>
        
    </div>
</template>

<script>
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
         name: 'EditSport',
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
        text-align: center;
        padding-top:5%;

        .text-view{
            color: rgb(104, 250, 59);
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

        .updateButton {
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

        .updateButton:hover {
            background-color:#5cbf2a;
        }

        .updateButton:active {
            position:relative;
            top:1px;
        }
    }
    
</style>
