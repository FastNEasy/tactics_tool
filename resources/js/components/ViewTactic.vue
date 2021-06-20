/* eslint-disable no-unused-vars */
<template>

    <div id="canvasTest">
       
        <div id="viewtactic">
            <h2>Tactic name is {{ tacticName }}</h2>
            
        </div>
        <div class="fieldAndInputs">
            <div class="field">
                <div class= "courtKonvas">
                    <table class="Court" style="overflow-x:auto;" >
                        <tr>
                            <td>
                                <v-stage class="stage"
                                    ref="stage"
                                    :config="configKonva"
                                >
                                    <v-layer ref="layer">
                                        <v-image :config="{
                                            width: configKonva.width,
                                            height: configKonva.height,
                                            image: img,
                                            listening: false,
                                            fillEnabled: true,
                                        }"/>
                                    </v-layer>
                                </v-stage>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>              
            <div class="inputs">
                <table class="actionTimeTable" style="overflow-x:auto;">
                    <tr>
                        <th></th>
                        <th>Action time (sec)</th>
                        <th>Save</th>
                    </tr>
                    <tr>
                        <td class= "IdCell">Action time (sec)</td>
                        <td class= "inputCell">
                            <input type="text" class="inputField" v-model="userInput.animDuration">
                        </td>
                        <td class= "saveButton"><button class="button">Save</button></td>
                    </tr>
                </table>
            </div>
           
        </div>
        <!-- <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p> -->
        <!-- <button @click="addPlayer">Add a player</button>
        <button @click="removePlayer">Remove a player</button>
        <button @click="lockCords">Lock in Cords!</button> -->
       
        <div class= "saveStartCords">
            <button class= "button" @click="animInit">Start animation!</button>
            <button class= "button" @click="animPlay">Play!</button>
            <button class= "button" @click="animPause">Pause!</button>
        </div>
        <!-- <button @click="addPlayerHome">Add Player test2</button> -->  
    </div>
</template>

<script>
    
    import Konva from "konva";
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        
        name: 'TestCanvas',
        created() {
            this.getData();
        },
        data() {
            return {
                coun: 0,
                sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                x1: 0,
                y1: 0,
                counter: 0,
                img: null,
                drawIt: false,
                tactics: {},
                id: this.$route.params.id,
                tacticName: null,
                presetID: null,
                ser : null,
                listHome: [], //this gets input
                listAway: [], //this gets input
                listBall: [],
                listBall2: [], //speles bumba info
                configKonva: {
                    width: 1000,
                    height: 500,
                },
                countHome : 0,//this gets input
                countAway : 0,//this gets input
                ballCount: 0,
                ballCount1:0, //bumba uz laukuma skaits
                ballEnabled: null,
                iter: null,
                setUp: 0,
                choiceId: null,
                isPlaying: 0,
                circle: null,
                cnt: 0,
                listHomePlayers: [],//this gets input
                listAwayPlayers: [],//this gets input
                identy: null,
                handledPlayersHome: [],//this gets input
                handledPlayersAway: [],
                placedCordsHome: [],
                placedCordsAway: [],
                count_times: 0,
                played: false,
                handledBall: [],
                userInput: {
                    animDuration: null,
                },
                savedData: {},
                tweens: [],
                speed: 0,
            }
        },
        mounted(){},
        methods: { 
            async getData(){
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                console.log('Data:', data);
                this.presetID = data.id_presets;
                this.savedData = JSON.parse(data.tactic_data);
                this.listHome = this.savedData.homeList;
                this.listAway = this.savedData.awayList;
                this.speed = this.savedData.speed;
                this.shoutout("Saved data:",this.savedData);
                this.userID = data.id_user;
                this.image=data.sports_type.field_picture;
                console.log('Data:', data.tactics_name);
                this.img = new window.Image();
                this.img.src = this.image;
                this.img.onload = () => {
                    // set image only when it is loaded
                };
                this.createPlayers();
            },
            createPlayers(){
                    for (const item of this.listHome) {
                        this.shoutout("Item: ", item);
                        var circle = new Konva.Circle({
                            x: item.preCords[0].x,
                            y: item.preCords[0].y,
                            id: item.id,
                            radius: 20,
                            fill: 'yellow',
                            opacity: 0.9,
                            draggable: false,
                            scaleX: item.id === item.id ? item.scale * 1.2 : item.scale,
                            scaleY: item.id === item.id ? item.scale * 1.2 : item.scale,
                            shadowColor: 'black',
                            shadowBlur: 10,
                            shadowOffsetX: item.id === item.id ? 15 : 5,
                            shadowOffsetY: item.id === item.id ? 15 : 5,
                            shadowOpacity: 0.6,
                            prevCords: item.preCords,
                            dragBoundFunc: function (pos){
                                this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                                this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                                return{
                                    x: this.x1,
                                    y: this.y1,
                                };
                            },
                        });
                        this.placedCordsHome.push(item.id);
                        this.$refs.layer.getNode().add(circle);
                        this.listHomePlayers.push({ id: item.id, circ: circle,});
                    }
            },
            animInit(e){
                for (const idplayer of this.placedCordsHome) {
                    var i = 1;
                    const item = this.listHome.find(i => i.id === idplayer);
                    const player = this.listHomePlayers.find(i => i.id === idplayer);
                    player.circ.position({
                        x: item.preCords[0].x,
                        y: item.preCords[0].y,
                    });
                    this.animStart(item, player.circ, i);
                }
                if(this.placedCordsAway.length == 0){ return;}
                for(const idplayer2 of this.placedCordsAway){
                    var j = 1;
                    const item2 = this.listAway.find(i => i.id === idplayer2);
                    const player2 = this.listAwayPlayers.find(i => i.id === idplayer2);
                    player2.circ.position({
                        x: item2.preCords[0].x,
                        y: item2.preCords[0].y,
                    });
                    this.animStart(item2, player2.circ, j);
                }
                return;
            },
            animStart(item,player,i){
                var tween = new Konva.Tween({
                    node: player,
                    duration: this.speed,
                    x: item.preCords[i].x,
                    y: item.preCords[i].y,
                    onUpdate: () => console.log("first tween updated"),
                    onFinish: () => {
                        console.log("first tween ended");
                        if(item.preCords[i+1]!= null){
                            player.position({
                                x: item.preCords[i].x,
                                y: item.preCords[i].y,
                            });
                            i++;
                            this.animStart(item,player,i);
                        }
                    },
                });
                this.tweens.push(tween);
                tween.play();
            },
            animPause(){
                for (const tween of this.tweens) {
                    this.shoutout(tween);
                    tween.pause();
                }
            },
            animPlay(){
               for (const tween of this.tweens) {
                    tween.play();
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
        
        #viewtactic{
            text-align: center;
        }
        // .stage{
        //     background-color:blue;
        // }
        .layer{
            background-color: rgb(23, 238, 23);
        }

        .stage{
            margin-top:1%;
        }

        .buttonDiv{
            width:70%;//mos samazinat
            display:table;
            margin-top:2%;
            margin-left:1%;
            text-align: center;
            
        }

        .Buttons{
            display:table-cell;
            margin-left: 20%;
            //float:left;
            //margin-left:4%;
        }

        .button{
            margin-top:20%;
            display:inline-block;
            padding:0.3em 1.2em;
            margin:0 0.3em 0.3em 0;
            border-radius:2em;
            box-sizing: border-box;
            text-decoration:none;
            font-family:Arial;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1db40f;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: rgb(25, 136, 30);
            color: white;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }           

        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgb(173, 173, 173);
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #1fc410;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #1fc410;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
            }

        .fieldAndInputs{
            display: flex;
            margin-left:3%;
            margin-top:1%;
            //height: 525px;
        }

        .field{
            flex: 1;
            //border: 2px solid rgb(0, 0, 0);
            margin-right: 20px;
        }

        .inputs{
            flex:1;
            //border: 2px solid rgb(0, 0, 0);
            float:left;
           //padding-right:1%;
           // margin-right: 2%;
            margin-top:5%;
            margin-right: 2%;
            //overflow-y: auto;
            height: 155px;
            
        }


        .actionTimeTable{
            font-family: Arial;
            border-collapse: collapse;
            width: 100%;
            background-color: #918f8f;
            border-collapse: collapse;
            //border: 1px solid black;
            margin:0 auto;
            th, td {
            border: 1px solid black;
            height: 50px;
            // padding-right: 50px;
            //margin-right: 2%;
         }
        }


        table, th, td {
            //border: 1px solid black;
            height: 50px;
            // padding-right: 50px;
            //margin-right: 2%;
        }
         
        table{
            float:left;
        }


        .IdCell{
            width:20%;
            text-align: center;
         }
        
        .inputCell{
            width: 50%;
            text-align: center;
            height: 80px;
        }

        .saveButton{
            width:30%;
            text-align: center;
        }

        .inputField{
            width:30%;
            height: 30px;
            font-size:16px;
              float:center; 
            margin-right: 5%;
            // float:center; //mos vajag
            // margin-right: 5%;
            //margin-left: 25%;
        }
        
        .inputField::placeholder{
            text-align: right;
            margin-right: 10%;
        }

        // .saveStartCords{
        //     // float:center;
        //    //margin-right: 7%;
        // //    margin: 0;
        // //     position: absolute;
        // //     top: 50%;
        // //     left: 50%;
 
        // }



    }
</style>